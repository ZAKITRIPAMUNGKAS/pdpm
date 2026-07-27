<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $table            = 'galeri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'deskripsi', 'file_path', 'tipe', 'kategori', 'id_penulis'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    // Mengatur updatedField menjadi string kosong untuk mencegah error query
    protected $updatedField  = ''; 

    /**
     * Mengambil data galeri lengkap dengan nama penulis.
     * @return array
     */
    public function getGaleriWithPenulis()
    {
        $builder = $this->db->table($this->table);
        $builder->select('galeri.*, COALESCE(users.nama_lengkap, "Admin") as nama_penulis');
        $builder->join('users', 'users.id = galeri.id_penulis', 'left');
        $builder->orderBy('galeri.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }
}
