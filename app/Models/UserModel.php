<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    // ...
    protected $allowedFields    = [
        'nama_lengkap',
        'email',
        'no_hp',
        'nbm',
        'alamat_rumah',
        'foto',
        'is_kokam',
        'jabatan',
        'password',
        'id_role',
        'id_cabang',
        'id_ranting',
        'status',
        'tipe_pimpinan',
        'jabatan_organisasi',
        'jabatan_struktural',
        'jabatan_bidang',
        'tanggal_lahir'
    ];

    // ... (sisa kode model tidak berubah)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserDetails($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*, users.no_hp as nomor_telepon, roles.nama_role, cabang.nama_cabang, ranting.nama_ranting');
        $builder->join('roles', 'roles.id = users.id_role');
        $builder->join('cabang', 'cabang.id = users.id_cabang', 'left');
        $builder->join('ranting', 'ranting.id = users.id_ranting', 'left');

        if ($id) {
            $builder->where('users.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    public function getUserDetailsByStatus(string $status, $cabangId = null, $isKokam = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*, users.no_hp as nomor_telepon, users.nbm, roles.nama_role, cabang.nama_cabang, ranting.nama_ranting');
        $builder->join('roles', 'roles.id = users.id_role');
        $builder->join('cabang', 'cabang.id = users.id_cabang', 'left');
        $builder->join('ranting', 'ranting.id = users.id_ranting', 'left');
        $builder->where('users.status', $status);
        
        // Tambahkan filter berdasarkan cabang jika diberikan dan valid
        if ($cabangId !== null && $cabangId !== '' && $cabangId > 0) {
            $builder->where('users.id_cabang', (int)$cabangId);
        }

        // Tambahkan filter berdasarkan KOKAM jika diberikan
        if ($isKokam !== null && ($isKokam === '0' || $isKokam === '1')) {
            $builder->where('users.is_kokam', (int)$isKokam);
        }
        
        // Exclude Super Admin (id_role = 1) and Admin (id_role = 2)
        $builder->whereNotIn('users.id_role', [1, 2]);

        return $builder->get()->getResultArray();
    }

    public function getUserDetailsByRole(string $roleName)
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*, roles.nama_role, cabang.nama_cabang');
        $builder->join('roles', 'roles.id = users.id_role');
        $builder->join('cabang', 'cabang.id = users.id_cabang', 'left');
        $builder->where('roles.nama_role', $roleName);
        
        return $builder->get()->getResultArray();
    }
}

