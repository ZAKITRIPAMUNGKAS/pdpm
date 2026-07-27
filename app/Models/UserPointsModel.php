<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPointsModel extends Model
{
    protected $table            = 'user_points';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'jenis_aktivitas', 'poin', 'deskripsi', 'id_referensi', 'tanggal_dapat'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Konstanta jenis aktivitas dan poin
    const AKTIVITAS_DAFTAR_AGENDA = 'daftar_agenda';
    const AKTIVITAS_HADIR_TEPAT_WAKTU = 'hadir_tepat_waktu';
    const AKTIVITAS_HADIR_TERLAMBAT = 'hadir_terlambat';
    const AKTIVITAS_LENGKAPI_PROFIL = 'lengkapi_profil';
    const AKTIVITAS_PERTAMA_KALI = 'pertama_kali';

    const POIN_DAFTAR_AGENDA = 10;
    const POIN_HADIR_TEPAT_WAKTU = 20;
    const POIN_HADIR_TERLAMBAT = 10;
    const POIN_LENGKAPI_PROFIL = 50;
    const POIN_PERTAMA_KALI = 100;

    /**
     * Tambah poin untuk user
     */
    public function tambahPoin($id_user, $jenis_aktivitas, $poin, $deskripsi, $id_referensi = null)
    {
        try {
            if ($this->sudahDapatPoin($id_user, $jenis_aktivitas, $id_referensi)) {
                return false;
            }

            $data = [
                'id_user' => $id_user,
                'jenis_aktivitas' => $jenis_aktivitas,
                'poin' => $poin,
                'deskripsi' => $deskripsi,
                'id_referensi' => $id_referensi,
                'tanggal_dapat' => date('Y-m-d H:i:s')
            ];

            return $this->save($data);
        } catch (\Exception $e) {
            log_message('error', 'Error menambah poin: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cek apakah user sudah dapat poin untuk aktivitas tertentu
     */
    public function sudahDapatPoin($id_user, $jenis_aktivitas, $id_referensi = null)
    {
        try {
            $builder = $this->where('id_user', $id_user)
                           ->where('jenis_aktivitas', $jenis_aktivitas);
            
            if ($id_referensi !== null) {
                $builder->where('id_referensi', $id_referensi);
            }

            return $builder->first() !== null;
        } catch (\Exception $e) {
            log_message('error', 'Error cek poin: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Hitung total poin user
     */
    public function getTotalPoin($id_user)
    {
        try {
            $result = $this->selectSum('poin')
                          ->where('id_user', $id_user)
                          ->first();
            
            return (int) ($result['poin'] ?? 0);
        } catch (\Exception $e) {
            log_message('error', 'Error get total poin: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Dapatkan level berdasarkan total poin
     */
    public function getLevel($total_poin)
    {
        $levels = [
            ['nama' => 'Anggota Baru', 'min_poin' => 0, 'max_poin' => 99, 'badge' => 'secondary', 'icon' => 'person'],
            ['nama' => 'Anggota Aktif', 'min_poin' => 100, 'max_poin' => 299, 'badge' => 'primary', 'icon' => 'person-check'],
            ['nama' => 'Anggota Berprestasi', 'min_poin' => 300, 'max_poin' => 599, 'badge' => 'success', 'icon' => 'star'],
            ['nama' => 'Anggota Teladan', 'min_poin' => 600, 'max_poin' => 999, 'badge' => 'warning', 'icon' => 'award'],
            ['nama' => 'Anggota Inspiratif', 'min_poin' => 1000, 'max_poin' => PHP_INT_MAX, 'badge' => 'danger', 'icon' => 'trophy']
        ];

        foreach ($levels as $level) {
            if ($total_poin >= $level['min_poin'] && $total_poin <= $level['max_poin']) {
                return $level;
            }
        }

        return $levels[0];
    }

    /**
     * Dapatkan progress ke level berikutnya
     */
    public function getProgressKeLevel($total_poin)
    {
        $level_sekarang = $this->getLevel($total_poin);
        
        if ($level_sekarang['max_poin'] === PHP_INT_MAX) {
            return [
                'level_sekarang' => $level_sekarang,
                'level_berikutnya' => null,
                'progress_persen' => 100,
                'poin_dibutuhkan' => 0
            ];
        }

        $poin_level_sekarang = $level_sekarang['min_poin'];
        $poin_level_berikutnya = $level_sekarang['max_poin'] + 1;
        $poin_dibutuhkan = $poin_level_berikutnya - $total_poin;
        
        $progress_persen = (($total_poin - $poin_level_sekarang) / ($poin_level_berikutnya - $poin_level_sekarang)) * 100;
        $progress_persen = min(100, max(0, $progress_persen));

        $level_berikutnya = $this->getLevel($poin_level_berikutnya);

        return [
            'level_sekarang' => $level_sekarang,
            'level_berikutnya' => $level_berikutnya,
            'progress_persen' => round($progress_persen, 1),
            'poin_dibutuhkan' => max(0, $poin_dibutuhkan)
        ];
    }

    /**
     * Proses otomatis pemberian poin berdasarkan aktivitas
     */
    public function prosesPoinOtomatis($id_user, $jenis_aktivitas, $id_referensi = null)
    {
        $poin_map = [
            self::AKTIVITAS_DAFTAR_AGENDA => [
                'poin' => self::POIN_DAFTAR_AGENDA,
                'deskripsi' => 'Mendaftar ke agenda kegiatan'
            ],
            self::AKTIVITAS_HADIR_TEPAT_WAKTU => [
                'poin' => self::POIN_HADIR_TEPAT_WAKTU,
                'deskripsi' => 'Hadir tepat waktu di kegiatan'
            ],
            self::AKTIVITAS_HADIR_TERLAMBAT => [
                'poin' => self::POIN_HADIR_TERLAMBAT,
                'deskripsi' => 'Hadir terlambat di kegiatan'
            ],
            self::AKTIVITAS_LENGKAPI_PROFIL => [
                'poin' => self::POIN_LENGKAPI_PROFIL,
                'deskripsi' => 'Melengkapi profil anggota'
            ],
            self::AKTIVITAS_PERTAMA_KALI => [
                'poin' => self::POIN_PERTAMA_KALI,
                'deskripsi' => 'Bonus anggota baru'
            ]
        ];

        if (!isset($poin_map[$jenis_aktivitas])) {
            return false;
        }

        $config = $poin_map[$jenis_aktivitas];
        
        return $this->tambahPoin(
            $id_user,
            $jenis_aktivitas,
            $config['poin'],
            $config['deskripsi'],
            $id_referensi
        );
    }

    /**
     * Dapatkan riwayat poin user
     */
    public function getRiwayatPoin($id_user, $limit = 10)
    {
        try {
            return $this->where('id_user', $id_user)
                       ->orderBy('tanggal_dapat', 'DESC')
                       ->limit($limit)
                       ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error get riwayat poin: ' . $e->getMessage());
            return [];
        }
    }
}