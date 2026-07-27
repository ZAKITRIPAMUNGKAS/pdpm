<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'slug', 'isi', 'gambar', 'id_penulis'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data berita lengkap dengan nama penulis.
     * @param int|null $limit
     * @param int|null $id
     * @return array
     */
    public function getBeritaWithPenulis($limit = null, $id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('berita.id, berita.judul, berita.slug, berita.isi, berita.gambar, berita.created_at, COALESCE(users.nama_lengkap, "Admin") as nama_penulis');
        $builder->join('users', 'users.id = berita.id_penulis', 'left');
        $builder->orderBy('berita.created_at', 'DESC'); // Urutkan dari yang terbaru

        if ($id) {
            $builder->where('berita.id', $id);
            return $builder->get()->getRowArray();
        }

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil satu berita berdasarkan slug-nya, lengkap dengan nama penulis.
     * @param string $slug
     * @return array|null
     */
    public function getBeritaBySlug($slug)
    {
        $builder = $this->db->table($this->table);
        $builder->select('berita.id, berita.judul, berita.slug, berita.isi, berita.gambar, berita.created_at, COALESCE(users.nama_lengkap, "Admin") as nama_penulis');
        $builder->join('users', 'users.id = berita.id_penulis', 'left');
        $builder->where('berita.slug', $slug);
        return $builder->get()->getRowArray();
    }

    /**
     * Mengambil berita berdasarkan ID cabang.
     * @param int $id_cabang
     * @param int|null $limit
     * @return array
     */
    public function getBeritaByCabang($id_cabang, $limit = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('berita.id, berita.judul, berita.slug, berita.isi, berita.gambar, berita.created_at, COALESCE(users.nama_lengkap, "Admin") as nama_penulis');
        $builder->join('users', 'users.id = berita.id_penulis', 'left');
        $builder->where('users.id_cabang', $id_cabang);
        $builder->orderBy('berita.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }
}
