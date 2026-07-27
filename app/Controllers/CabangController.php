<?php

namespace App\Controllers;

use App\Models\CabangModel;
use App\Models\StrukturCabangModel;
use App\Models\UserModel;
use App\Models\BeritaModel;
use App\Models\RantingModel;
use App\Models\AgendaModel;

class CabangController extends BaseController
{
    protected $cabangModel;
    protected $strukturModel;
    protected $userModel;
    protected $beritaModel;
    protected $rantingModel;
    protected $agendaModel;

    public function __construct()
    {
        $this->cabangModel = new CabangModel();
        $this->strukturModel = new StrukturCabangModel();
        $this->userModel = new UserModel();
        $this->beritaModel = new BeritaModel();
        $this->rantingModel = new RantingModel();
        $this->agendaModel = new AgendaModel();
        helper(['form', 'url', 'text']);
    }

    /**
     * PUBLIC PAGES - Daftar semua cabang yang sudah completed
     */
    public function index()
    {
        $data = [
            'title'         => 'Daftar Cabang - PDPM Karanganyar',
            'cabang_list'   => $this->cabangModel->getCompletedCabang()
        ];

        return view('cabang/index', $data);
    }

    /**
     * PUBLIC PAGES - Detail cabang berdasarkan slug
     */
    public function detail($cabang_slug)
    {
        $cabang = $this->cabangModel->getProfileBySlug($cabang_slug);

        if (!$cabang || !$cabang['is_completed']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cabang tidak ditemukan atau belum lengkap.');
        }

        // Removed: $struktur = $this->strukturModel->getStrukturByCabang($cabang['id']);
        $stats = $this->getStatistikCabang($cabang['id']);
        $berita_cabang = $this->beritaModel->getBeritaByCabang($cabang['id'], 3);

        // NEW: Fetch users for this branch with their roles and positions (include all active members)
                                $anggota_cabang = $this->userModel
                               ->select('users.nama_lengkap, users.jabatan_organisasi, users.jabatan_struktural, users.jabatan_bidang, users.foto, roles.nama_role, users.status')
                               ->join('roles', 'roles.id = users.id_role')
                               ->where('users.id_cabang', $cabang['id'])
                               ->where('users.status', 'Aktif')
                               ->whereNotIn('users.id_role', [1, 2]) // Exclude Super Admin and Admin
                               ->orderBy('users.jabatan_organisasi', 'ASC')
                               ->orderBy('users.jabatan_struktural', 'ASC')
                               ->findAll();

        $data = [
            'title' => 'Cabang ' . $cabang['nama_cabang'] . ' - PDPM Karanganyar',
            'cabang' => $cabang,
            // Removed: 'struktur' => $struktur,
            'stats' => $stats,
            'berita_cabang' => $berita_cabang,
            'anggota_cabang' => $anggota_cabang, // NEW
        ];

        return view('cabang/detail', $data);
    }

    /**
     * ADMIN PAGES - Halaman profil untuk admin cabang
     */
    public function admin_profile()
    {
        $user = session()->get('user');
        if ($user['id_role'] != 3) { // Hanya Admin Cabang
            return redirect()->to('/dashboard')->with('error', 'Akses hanya untuk Admin Cabang.');
        }

        $profile = $this->cabangModel->getOrCreateProfileByAdminId($user['id']);

        $data = [
            'title' => 'Manajemen Profil Cabang',
            'profile' => $profile,
            'user' => $user,
        ];

        return view('admin/cabang/profile', $data);
    }

    /**
     * Update profil cabang oleh Admin Cabang
     */
    public function update_profile()
    {
        $user = session()->get('user');
        if ($user['id_role'] != 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        $data = [
            'nama_cabang' => $this->request->getPost('nama_cabang'),
            'nama_ketua' => $this->request->getPost('nama_ketua'),
            'nama_sekretaris' => $this->request->getPost('nama_sekretaris'),
            'nama_bendahara' => $this->request->getPost('nama_bendahara'),
            'cp_cabang' => $this->request->getPost('cp_cabang'),
            'email_cabang' => $this->request->getPost('email_cabang'),
            'alamat_sekretariat' => $this->request->getPost('alamat_sekretariat'),
            'deskripsi_cabang' => $this->request->getPost('deskripsi_cabang'),
            'instagram' => $this->request->getPost('instagram'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'youtube' => $this->request->getPost('youtube'),
            'website' => $this->request->getPost('website'),
            'is_completed' => true, // Set as completed
        ];

        $foto = $this->request->getFile('foto_sekretariat');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(WRITEPATH . '../public/uploads/cabang/', $newName);
            $data['foto_sekretariat'] = $newName;
        }

        if ($this->cabangModel->updateProfileByAdminId($user['id'], $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Profil cabang berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui profil cabang']);
        }
    }

    // ... (Metode lain seperti admin_struktur, add_struktur, dll. perlu disesuaikan juga)

    private function getStatistikCabang($id_cabang)
    {
        // Count active members for this cabang (exclude admin roles: 1=Super Admin, 2=Admin, 3=Admin Cabang)
                                        $totalAnggota = $this->userModel->where('id_cabang', $id_cabang)
                                        ->where('status', 'Aktif')
                                        ->where('id_role !=', 3) // Exclude Admin Cabang
                                        ->countAllResults();
        
        // Count active KOKAM members for this cabang (assuming KOKAM is role ID 4 or higher)
                $totalKokam = $this->userModel->where('id_cabang', $id_cabang)
                                      ->where('status', 'Aktif')
                                      ->where('is_kokam', 1)
                                      ->countAllResults();

        // Calculate totalRanting using RantingModel
        $totalRanting = $this->rantingModel->where('id_cabang', $id_cabang)->countAllResults();

        return [
            'total_anggota' => $totalAnggota,
            'total_kokam'   => $totalKokam,
            'total_ranting' => $totalRanting,
        ];
    }
}
