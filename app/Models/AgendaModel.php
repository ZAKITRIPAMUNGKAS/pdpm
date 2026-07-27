<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 'agenda';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_kegiatan', 
        'deskripsi', 
        'lokasi', 
        'latitude', 
        'longitude', 
        'radius_meter', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'jam_mulai', 
        'jam_selesai', 
        'id_penulis', 
        'tingkat_agenda', 
        'id_cabang_khusus'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data agenda lengkap dengan nama penulis dan info cabang.
     * @return array
     */
    public function getAgendaWithPenulis()
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            agenda.*, 
            COALESCE(users.nama_lengkap, "Admin") as nama_penulis,
            users.id_role as role_penulis,
            cabang.nama_cabang,
            cabang.alamat_sekretariat as wilayah
        ');
        $builder->join('users', 'users.id = agenda.id_penulis', 'left');
        $builder->join('cabang', 'cabang.id = agenda.id_cabang_khusus', 'left');
        $builder->orderBy('agenda.tanggal_mulai', 'DESC'); // Yang paling terbaru di atas
        $builder->orderBy('agenda.tingkat_agenda', 'ASC'); // Daerah dulu, baru cabang

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil data agenda dengan informasi absensi dan role penulis untuk dashboard superadmin.
     * @return array
     */
    public function getAgendaWithAbsensiStats()
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            agenda.*,
            COALESCE(users.nama_lengkap, "Admin") as nama_penulis,
            users.id_role as role_penulis,
            roles.nama_role as nama_role_penulis,
            cabang.nama_cabang,
            cabang.alamat_sekretariat as wilayah,
            COUNT(DISTINCT agenda_peserta.id) as total_peserta,
            COUNT(DISTINCT absensi_kegiatan.id) as total_hadir,
            CASE 
                WHEN COUNT(DISTINCT agenda_peserta.id) > 0 
                THEN ROUND((COUNT(DISTINCT absensi_kegiatan.id) / COUNT(DISTINCT agenda_peserta.id)) * 100, 1)
                ELSE 0 
            END as persentase_kehadiran
        ');
        $builder->join('users', 'users.id = agenda.id_penulis', 'left');
        $builder->join('roles', 'roles.id = users.id_role', 'left');
        $builder->join('cabang', 'cabang.id = agenda.id_cabang_khusus', 'left');
        $builder->join('agenda_peserta', 'agenda_peserta.id_agenda = agenda.id AND agenda_peserta.status_pendaftaran = "terdaftar"', 'left');
        $builder->join('absensi_kegiatan', 'absensi_kegiatan.id_agenda = agenda.id', 'left');
        $builder->groupBy('agenda.id');
        $builder->orderBy('agenda.tanggal_mulai', 'DESC'); // Yang paling terbaru di atas
        $builder->orderBy('agenda.tingkat_agenda', 'ASC'); // Daerah dulu, baru cabang

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil agenda berdasarkan tingkat (daerah/cabang).
     * @param string $tingkat
     * @return array
     */
    public function getAgendaByTingkat($tingkat = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            agenda.*, 
            COALESCE(users.nama_lengkap, "Admin") as nama_penulis,
            users.id_role as role_penulis,
            cabang.nama_cabang,
            cabang.alamat_sekretariat as wilayah
        ');
        $builder->join('users', 'users.id = agenda.id_penulis', 'left');
        $builder->join('cabang', 'cabang.id = agenda.id_cabang_khusus', 'left');
        
        if ($tingkat) {
            $builder->where('agenda.tingkat_agenda', $tingkat);
        }
        
        $builder->orderBy('agenda.tanggal_mulai', 'DESC'); // Yang paling terbaru di atas
        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil agenda untuk cabang tertentu.
     * @param int $id_cabang
     * @return array
     */
    public function getAgendaForCabang($id_cabang)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            agenda.*, 
            COALESCE(users.nama_lengkap, "Admin") as nama_penulis,
            users.id_role as role_penulis,
            cabang.nama_cabang,
            cabang.alamat_sekretariat as wilayah
        ');
        $builder->join('users', 'users.id = agenda.id_penulis', 'left');
        $builder->join('cabang', 'cabang.id = agenda.id_cabang_khusus', 'left');
        
        // Agenda daerah (untuk semua) atau agenda khusus cabang ini
        $builder->groupStart();
        $builder->where('agenda.tingkat_agenda', 'daerah');
        $builder->orWhere('agenda.id_cabang_khusus', $id_cabang);
        $builder->groupEnd();
        
        $builder->orderBy('agenda.tanggal_mulai', 'DESC'); // Yang paling terbaru di atas
        $builder->orderBy('agenda.tingkat_agenda', 'ASC'); // Daerah dulu
        
        return $builder->get()->getResultArray();
    }
}
