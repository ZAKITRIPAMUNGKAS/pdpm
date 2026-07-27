<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaPesertaModel extends Model
{
    protected $table            = 'agenda_peserta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_agenda', 'id_user', 'status_pendaftaran', 'tanggal_daftar', 'tanggal_batal'];

    // Dates
    protected $useTimestamps = false; // Menggunakan tanggal_daftar custom
    protected $dateFormat    = 'datetime';

    /**
     * Mengambil data peserta agenda dengan detail user.
     * @param int $id_agenda
     * @return array
     */
    public function getPesertaByAgenda($id_agenda)
    {
        $builder = $this->db->table($this->table);
        $builder->select('agenda_peserta.*, users.nama_lengkap, users.email, users.no_hp');
        $builder->join('users', 'users.id = agenda_peserta.id_user');
        $builder->where('agenda_peserta.id_agenda', $id_agenda);
        $builder->where('agenda_peserta.status_pendaftaran', 'terdaftar');
        $builder->orderBy('agenda_peserta.tanggal_daftar', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil agenda yang diikuti oleh user.
     * @param int $id_user
     * @return array
     */
    public function getAgendaByUser($id_user)
    {
        $builder = $this->db->table($this->table);
        $builder->select('agenda_peserta.*, agenda.nama_kegiatan, agenda.tanggal_mulai, agenda.tanggal_selesai, agenda.lokasi');
        $builder->join('agenda', 'agenda.id = agenda_peserta.id_agenda');
        $builder->where('agenda_peserta.id_user', $id_user);
        $builder->where('agenda_peserta.status_pendaftaran', 'terdaftar');
        $builder->orderBy('agenda.tanggal_mulai', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Cek apakah user sudah terdaftar di agenda (dengan handling yang lebih robust).
     * @param int $id_agenda
     * @param int $id_user
     * @return bool
     */
    public function isUserRegistered($id_agenda, $id_user)
    {
        try {
            $result = $this->where('id_agenda', $id_agenda)
                          ->where('id_user', $id_user)
                          ->where('status_pendaftaran', 'terdaftar')
                          ->first();
            
            return !empty($result);
        } catch (\Exception $e) {
            // Jika ada error, assume tidak terdaftar untuk safety
            log_message('error', 'Error checking user registration: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mendaftarkan user ke agenda dengan transaction handling.
     * @param int $id_agenda
     * @param int $id_user
     * @return array ['success' => bool, 'message' => string, 'id' => int|null]
     */
    public function daftarKeAgenda($id_agenda, $id_user)
    {
        // Validasi input
        if (empty($id_agenda) || empty($id_user)) {
            return [
                'success' => false,
                'message' => 'Data agenda atau user tidak valid',
                'id' => null
            ];
        }

        // Cek apakah sudah terdaftar
        if ($this->isUserRegistered($id_agenda, $id_user)) {
            return [
                'success' => false,
                'message' => 'User sudah terdaftar di agenda ini',
                'id' => null
            ];
        }

        // Validasi apakah agenda masih tersedia
        $agendaModel = new \App\Models\AgendaModel();
        $agenda = $agendaModel->find($id_agenda);
        if (!$agenda) {
            return [
                'success' => false,
                'message' => 'Agenda tidak ditemukan',
                'id' => null
            ];
        }

        // Cek apakah agenda masih bisa didaftari (belum lewat tanggal)
        $now = date('Y-m-d H:i:s');
        $batasRegistrasi = $agenda['tanggal_mulai'] . ' ' . ($agenda['jam_mulai'] ?? '00:00:00');
        if ($now > $batasRegistrasi) {
            return [
                'success' => false,
                'message' => 'Pendaftaran sudah ditutup',
                'id' => null
            ];
        }

        // Mulai transaction
        $this->db->transStart();

        try {
            // Siapkan data pendaftaran
            $now = date('Y-m-d H:i:s');
            $data = [
                'id_agenda' => $id_agenda,
                'id_user' => $id_user,
                'status_pendaftaran' => 'terdaftar',
                'tanggal_daftar' => $now
            ];

            // Simpan data
            $result = $this->save($data);
            
            if (!$result) {
                $this->db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan data pendaftaran',
                    'id' => null
                ];
            }

            // Commit transaction
            $this->db->transCommit();

            // Log aktivitas
            log_message('info', "User {$id_user} berhasil mendaftar ke agenda {$id_agenda}");

            return [
                'success' => true,
                'message' => 'Berhasil mendaftar ke agenda',
                'id' => $this->getInsertID()
            ];

        } catch (\Exception $e) {
            // Rollback transaction
            $this->db->transRollback();

            // Handle specific errors
            if (strpos($e->getMessage(), 'Duplicate entry') !== false || 
                strpos($e->getMessage(), 'unique_peserta') !== false) {
                
                // Double check apakah user sudah terdaftar
                if ($this->isUserRegistered($id_agenda, $id_user)) {
                    return [
                        'success' => false,
                        'message' => 'User sudah terdaftar di agenda ini',
                        'id' => null
                    ];
                }
            }

            // Log error
            log_message('error', 'Error mendaftarkan user ke agenda: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'id' => null
            ];
        }
    }

    /**
     * Batalkan pendaftaran user dari agenda dengan validation.
     * @param int $id_agenda
     * @param int $id_user
     * @return array ['success' => bool, 'message' => string]
     */
    public function batalkanPendaftaran($id_agenda, $id_user)
    {
        // Validasi input
        if (empty($id_agenda) || empty($id_user)) {
            return [
                'success' => false,
                'message' => 'Data agenda atau user tidak valid'
            ];
        }

        // Cek apakah user terdaftar
        if (!$this->isUserRegistered($id_agenda, $id_user)) {
            return [
                'success' => false,
                'message' => 'User tidak terdaftar di agenda ini'
            ];
        }

        // Cek apakah sudah absen (tidak bisa batal jika sudah absen)
        $absensiModel = new \App\Models\AbsensiKegiatanModel();
        if ($absensiModel->isUserAbsen($id_agenda, $id_user)) {
            return [
                'success' => false,
                'message' => 'Tidak dapat membatalkan pendaftaran karena sudah melakukan absensi'
            ];
        }

        // Mulai transaction
        $this->db->transStart();

        try {
            // Update status pendaftaran
            $result = $this->where('id_agenda', $id_agenda)
                          ->where('id_user', $id_user)
                          ->set([
                              'status_pendaftaran' => 'batal',
                              'tanggal_batal' => date('Y-m-d H:i:s')
                          ])
                          ->update();

            if (!$result) {
                $this->db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Gagal membatalkan pendaftaran'
                ];
            }

            // Commit transaction
            $this->db->transCommit();

            // Log aktivitas
            log_message('info', "User {$id_user} membatalkan pendaftaran agenda {$id_agenda}");

            return [
                'success' => true,
                'message' => 'Pendaftaran berhasil dibatalkan'
            ];

        } catch (\Exception $e) {
            // Rollback transaction
            $this->db->transRollback();

            // Log error
            log_message('error', 'Error membatalkan pendaftaran: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ];
        }
    }

    /**
     * Cek apakah user bisa mendaftar ke agenda.
     * @param int $id_agenda
     * @param int $id_user
     * @return array ['can_register' => bool, 'reason' => string]
     */
    public function canUserRegister($id_agenda, $id_user)
    {
        // Cek apakah sudah terdaftar
        if ($this->isUserRegistered($id_agenda, $id_user)) {
            return [
                'can_register' => false,
                'reason' => 'User sudah terdaftar di agenda ini'
            ];
        }

        // Validasi agenda
        $agendaModel = new \App\Models\AgendaModel();
        $agenda = $agendaModel->find($id_agenda);
        if (!$agenda) {
            return [
                'can_register' => false,
                'reason' => 'Agenda tidak ditemukan'
            ];
        }

        // Cek apakah agenda masih bisa didaftari
        $now = date('Y-m-d H:i:s');
        $batasRegistrasi = $agenda['tanggal_mulai'] . ' ' . ($agenda['jam_mulai'] ?? '00:00:00');
        if ($now > $batasRegistrasi) {
            return [
                'can_register' => false,
                'reason' => 'Pendaftaran sudah ditutup'
            ];
        }

        return [
            'can_register' => true,
            'reason' => 'User dapat mendaftar'
        ];
    }

    /**
     * Hapus pendaftaran user dari agenda (hard delete).
     * @param int $id_agenda
     * @param int $id_user
     * @return array ['success' => bool, 'message' => string]
     */
    public function hapusPendaftaran($id_agenda, $id_user)
    {
        // Validasi input
        if (empty($id_agenda) || empty($id_user)) {
            return [
                'success' => false,
                'message' => 'Data agenda atau user tidak valid'
            ];
        }

        // Cek apakah sudah absen (tidak bisa hapus jika sudah absen)
        $absensiModel = new \App\Models\AbsensiKegiatanModel();
        if ($absensiModel->isUserAbsen($id_agenda, $id_user)) {
            return [
                'success' => false,
                'message' => 'Tidak dapat menghapus pendaftaran karena sudah melakukan absensi'
            ];
        }

        // Mulai transaction
        $this->db->transStart();

        try {
            // Hapus data pendaftaran
            $result = $this->where('id_agenda', $id_agenda)
                          ->where('id_user', $id_user)
                          ->delete();

            if (!$result) {
                $this->db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Gagal menghapus pendaftaran'
                ];
            }

            // Commit transaction
            $this->db->transCommit();

            // Log aktivitas
            log_message('info', "Pendaftaran user {$id_user} di agenda {$id_agenda} dihapus");

            return [
                'success' => true,
                'message' => 'Pendaftaran berhasil dihapus'
            ];

        } catch (\Exception $e) {
            // Rollback transaction
            $this->db->transRollback();

            // Log error
            log_message('error', 'Error menghapus pendaftaran: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ];
        }
    }

    /**
     * Hitung jumlah peserta terdaftar per agenda.
     * @param int $id_agenda
     * @return int
     */
    public function countPeserta($id_agenda)
    {
        return $this->where('id_agenda', $id_agenda)
                   ->where('status_pendaftaran', 'terdaftar')
                   ->countAllResults();
    }
}
