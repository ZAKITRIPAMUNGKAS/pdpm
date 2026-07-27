<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiKegiatanModel extends Model
{
    protected $table            = 'absensi_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_agenda', 'id_user', 'waktu_absen', 'latitude_absen', 'longitude_absen', 'jarak_meter', 'status_absen', 'keterangan'];

    // Dates
    protected $useTimestamps = false; // Menggunakan waktu_absen custom
    protected $dateFormat    = 'datetime';

    // Validation rules
    protected $validationRules = [
        'id_agenda'        => 'required|integer',
        'id_user'          => 'required|integer',
        'latitude_absen'   => 'required|decimal',
        'longitude_absen'  => 'required|decimal',
        'jarak_meter'      => 'required|decimal',
        'status_absen'     => 'required|in_list[hadir,terlambat]'
    ];

    protected $validationMessages = [
        'id_agenda' => [
            'required' => 'ID Agenda harus diisi',
            'integer'  => 'ID Agenda harus berupa angka'
        ],
        'id_user' => [
            'required' => 'ID User harus diisi',
            'integer'  => 'ID User harus berupa angka'
        ],
        'latitude_absen' => [
            'required' => 'Latitude absensi harus diisi',
            'decimal'  => 'Latitude harus berupa angka desimal'
        ],
        'longitude_absen' => [
            'required' => 'Longitude absensi harus diisi',
            'decimal'  => 'Longitude harus berupa angka desimal'
        ],
        'jarak_meter' => [
            'required' => 'Jarak meter harus diisi',
            'decimal'  => 'Jarak harus berupa angka desimal'
        ],
        'status_absen' => [
            'required' => 'Status absensi harus diisi',
            'in_list'  => 'Status absensi harus hadir atau terlambat'
        ]
    ];

    /**
     * Mengambil data absensi per agenda dengan detail user.
     * @param int $id_agenda
     * @return array
     */
    public function getAbsensiByAgenda($id_agenda)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('absensi_kegiatan.*, users.nama_lengkap, users.email, users.no_hp');
            $builder->join('users', 'users.id = absensi_kegiatan.id_user');
            $builder->where('absensi_kegiatan.id_agenda', $id_agenda);
            $builder->orderBy('absensi_kegiatan.waktu_absen', 'ASC');

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting absensi by agenda: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mengambil riwayat absensi user.
     * @param int $id_user
     * @param int $limit
     * @return array
     */
    public function getRiwayatAbsensiUser($id_user, $limit = null)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('absensi_kegiatan.*, agenda.nama_kegiatan, agenda.tanggal_mulai, agenda.tanggal_selesai, agenda.jam_mulai, agenda.jam_selesai, agenda.lokasi');
            $builder->join('agenda', 'agenda.id = absensi_kegiatan.id_agenda');
            $builder->where('absensi_kegiatan.id_user', $id_user);
            $builder->orderBy('absensi_kegiatan.waktu_absen', 'DESC');
            
            if ($limit) {
                $builder->limit($limit);
            }

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting riwayat absensi user: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Cek apakah user sudah absen di agenda.
     * @param int $id_agenda
     * @param int $id_user
     * @return bool
     */
    public function isUserAbsen($id_agenda, $id_user)
    {
        try {
            $result = $this->where('id_agenda', $id_agenda)
                          ->where('id_user', $id_user)
                          ->first();
            
            return !empty($result);
        } catch (\Exception $e) {
            log_message('error', 'Error checking user absen: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Simpan data absensi user dengan validasi.
     * @param array $data
     * @return bool|int
     */
    public function simpanAbsensi($data)
    {
        try {
            // Cek apakah sudah absen
            if ($this->isUserAbsen($data['id_agenda'], $data['id_user'])) {
                return false; // Sudah absen
            }

            // Set waktu absen jika belum ada
            if (!isset($data['waktu_absen'])) {
                $data['waktu_absen'] = date('Y-m-d H:i:s');
            }

            // Validasi data
            if (!$this->validate($data)) {
                log_message('error', 'Validation failed: ' . json_encode($this->errors()));
                return false;
            }

            return $this->save($data);
        } catch (\Exception $e) {
            log_message('error', 'Error saving absensi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Hitung statistik absensi per agenda.
     * @param int $id_agenda
     * @return array
     */
    public function getStatistikAbsensi($id_agenda)
    {
        try {
            // Total yang hadir
            $hadir = $this->where('id_agenda', $id_agenda)->countAllResults();
            
            // Total yang terdaftar
            $pesertaModel = new \App\Models\AgendaPesertaModel();
            $terdaftar = $pesertaModel->countPeserta($id_agenda);
            
            // Breakdown by status
            $builder = $this->db->table($this->table);
            $builder->select('status_absen, COUNT(*) as jumlah');
            $builder->where('id_agenda', $id_agenda);
            $builder->groupBy('status_absen');
            $statusBreakdown = $builder->get()->getResultArray();
            
            $tepat_waktu = 0;
            $terlambat = 0;
            
            foreach ($statusBreakdown as $status) {
                if ($status['status_absen'] === 'hadir') {
                    $tepat_waktu = $status['jumlah'];
                } elseif ($status['status_absen'] === 'terlambat') {
                    $terlambat = $status['jumlah'];
                }
            }
            
            // Persentase kehadiran
            $persentase = $terdaftar > 0 ? round(($hadir / $terdaftar) * 100, 2) : 0;
            
            return [
                'total_terdaftar' => $terdaftar,
                'total_hadir' => $hadir,
                'total_tidak_hadir' => $terdaftar - $hadir,
                'tepat_waktu' => $tepat_waktu,
                'terlambat' => $terlambat,
                'persentase_kehadiran' => $persentase
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error getting statistik absensi: ' . $e->getMessage());
            return [
                'total_terdaftar' => 0,
                'total_hadir' => 0,
                'total_tidak_hadir' => 0,
                'tepat_waktu' => 0,
                'terlambat' => 0,
                'persentase_kehadiran' => 0
            ];
        }
    }

    /**
     * Export data absensi untuk agenda tertentu.
     * @param int $id_agenda
     * @return array
     */
    public function getDataExport($id_agenda)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('
                users.nama_lengkap,
                users.email,
                users.no_hp,
                absensi_kegiatan.waktu_absen,
                absensi_kegiatan.status_absen,
                absensi_kegiatan.jarak_meter,
                absensi_kegiatan.keterangan,
                agenda.nama_kegiatan,
                agenda.tanggal_mulai,
                agenda.lokasi
            ');
            $builder->join('users', 'users.id = absensi_kegiatan.id_user');
            $builder->join('agenda', 'agenda.id = absensi_kegiatan.id_agenda');
            $builder->where('absensi_kegiatan.id_agenda', $id_agenda);
            $builder->orderBy('absensi_kegiatan.waktu_absen', 'ASC');

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting data export: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Hitung total kehadiran user.
     * @param int $id_user
     * @return int
     */
    public function getTotalKehadiranUser($id_user)
    {
        try {
            return $this->where('id_user', $id_user)->countAllResults();
        } catch (\Exception $e) {
            log_message('error', 'Error getting total kehadiran user: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Dapatkan agenda dengan kehadiran terbanyak.
     * @param int $limit
     * @return array
     */
    public function getAgendaTerpopuler($limit = 5)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('agenda.nama_kegiatan, agenda.tanggal_mulai, COUNT(absensi_kegiatan.id) as total_hadir');
            $builder->join('agenda', 'agenda.id = absensi_kegiatan.id_agenda');
            $builder->groupBy('absensi_kegiatan.id_agenda');
            $builder->orderBy('total_hadir', 'DESC');
            $builder->limit($limit);

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting agenda terpopuler: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get absensi data with GPS accuracy analysis.
     * @param int $id_agenda
     * @return array
     */
    public function getAbsensiWithGpsAnalysis($id_agenda)
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select('
                absensi_kegiatan.*,
                users.nama_lengkap,
                users.email,
                CASE 
                    WHEN absensi_kegiatan.jarak_meter <= 5 THEN "Sangat Akurat"
                    WHEN absensi_kegiatan.jarak_meter <= 10 THEN "Akurat"
                    WHEN absensi_kegiatan.jarak_meter <= 25 THEN "Cukup Akurat"
                    WHEN absensi_kegiatan.jarak_meter <= 50 THEN "Kurang Akurat"
                    ELSE "Tidak Akurat"
                END as tingkat_akurasi
            ');
            $builder->join('users', 'users.id = absensi_kegiatan.id_user');
            $builder->where('absensi_kegiatan.id_agenda', $id_agenda);
            $builder->orderBy('absensi_kegiatan.waktu_absen', 'ASC');

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error getting absensi with GPS analysis: ' . $e->getMessage());
            return [];
        }
    }
}
