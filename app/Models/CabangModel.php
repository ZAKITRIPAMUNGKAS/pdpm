<?php

namespace App\Models;

use CodeIgniter\Model;

class CabangModel extends Model
{
    protected $table            = 'cabang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_cabang',
        'nama_ketua',
        'nama_sekretaris',
        'nama_bendahara',
        'cp_cabang',
        'email_cabang',
        'alamat_sekretariat',
        'foto_sekretariat',
        'instagram',
        'facebook',
        'twitter',
        'youtube',
        'website',
        'deskripsi_cabang',
        'is_completed',
        'admin_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nama_cabang' => 'required|max_length[100]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get all completed cabang profiles for public display
     */
    public function getCompletedCabang()
    {
        return $this->where('is_completed', true)->findAll();
    }

    /**
     * Get cabang profile by slug
     */
    public function getProfileBySlug($slug)
    {
        $cabang_name = str_replace('-', ' ', $slug);
        return $this->where('nama_cabang', $cabang_name)->first();
    }

    /**
     * Get or create profile for cabang by admin_id
     */
    public function getOrCreateProfileByAdminId($admin_id)
    {
        $profile = $this->where('admin_id', $admin_id)->first();
        
        if (!$profile) {
            // Create a new cabang record for this admin
            $this->insert(['admin_id' => $admin_id, 'is_completed' => false]);
            $profile = $this->where('admin_id', $admin_id)->first();
        }
        
        return $profile;
    }

    /**
     * Update profile by admin_id
     */
    public function updateProfileByAdminId($admin_id, $data)
    {
        $profile = $this->where('admin_id', $admin_id)->first();
        
        if ($profile) {
            return $this->update($profile['id'], $data);
        } else {
            return false;
        }
    }
}