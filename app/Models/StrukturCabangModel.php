<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturCabangModel extends Model
{
    protected $table            = 'struktur_cabang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_cabang',
        'nama_lengkap',
        'jabatan',
        'foto',
        'urutan_tampil',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'id_cabang'    => 'required|integer',
        'nama_lengkap' => 'required|max_length[255]',
        'jabatan'      => 'required|max_length[255]',
        'urutan_tampil' => 'permit_empty|integer',
        'status'       => 'permit_empty|in_list[aktif,tidak_aktif]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get struktur cabang by cabang ID
     */
    public function getStrukturByCabang($id_cabang)
    {
        return $this->where('id_cabang', $id_cabang)
                   ->where('status', 'aktif')
                   ->orderBy('urutan_tampil', 'ASC')
                   ->orderBy('id', 'ASC')
                   ->findAll();
    }

    /**
     * Get struktur with cabang details
     */
    public function getStrukturWithCabang($id_cabang = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('struktur_cabang.*, cabang.nama_cabang');
        $builder->join('cabang', 'cabang.id = struktur_cabang.id_cabang', 'left');
        $builder->where('struktur_cabang.status', 'aktif');

        if ($id_cabang) {
            $builder->where('struktur_cabang.id_cabang', $id_cabang);
        }

        $builder->orderBy('struktur_cabang.urutan_tampil', 'ASC');
        $builder->orderBy('struktur_cabang.id', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Update urutan tampil
     */
    public function updateUrutan($id, $urutan_baru)
    {
        return $this->update($id, ['urutan_tampil' => $urutan_baru]);
    }

    /**
     * Get struktur by jabatan (untuk mencari ketua, sekretaris, dll)
     */
    public function getByJabatan($id_cabang, $jabatan)
    {
        return $this->where('id_cabang', $id_cabang)
                   ->where('status', 'aktif')
                   ->like('jabatan', $jabatan, 'both')
                   ->first();
    }

    /**
     * Get all struktur for admin management
     */
    public function getAllStrukturForAdmin($id_cabang)
    {
        return $this->where('id_cabang', $id_cabang)
                   ->orderBy('urutan_tampil', 'ASC')
                   ->orderBy('status', 'DESC') // aktif dulu, baru tidak_aktif
                   ->findAll();
    }

    /**
     * Activate/Deactivate struktur
     */
    public function toggleStatus($id)
    {
        $struktur = $this->find($id);
        if ($struktur) {
            $new_status = ($struktur['status'] === 'aktif') ? 'tidak_aktif' : 'aktif';
            return $this->update($id, ['status' => $new_status]);
        }
        return false;
    }

    /**
     * Get struktur count by cabang
     */
    public function getCountByCabang($id_cabang)
    {
        return $this->where('id_cabang', $id_cabang)
                   ->where('status', 'aktif')
                   ->countAllResults();
    }

    /**
     * Reorder struktur (untuk drag & drop)
     */
    public function reorderStruktur($id_cabang, $new_order)
    {
        $this->db->transStart();

        foreach ($new_order as $index => $struktur_id) {
            $this->update($struktur_id, [
                'urutan_tampil' => $index + 1
            ]);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Get struktur for public display (with cabang info)
     */
    public function getPublicStruktur($cabang_slug = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            struktur_cabang.*,
            cabang.nama_cabang,
            cabang.id as cabang_id
        ');
        $builder->join('cabang', 'cabang.id = struktur_cabang.id_cabang', 'left');
        $builder->where('struktur_cabang.status', 'aktif');

        if ($cabang_slug) {
            // Convert slug to cabang name
            $cabang_name = str_replace('-', ' ', $cabang_slug);
            $builder->like('cabang.nama_cabang', $cabang_name, 'both');
        }

        $builder->orderBy('struktur_cabang.urutan_tampil', 'ASC');
        $builder->orderBy('struktur_cabang.id', 'ASC');

        return $builder->get()->getResultArray();
    }
}
