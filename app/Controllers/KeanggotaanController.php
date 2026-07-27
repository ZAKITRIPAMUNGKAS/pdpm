<?php
// File: app/Controllers/KeanggotaanController.php
// Penjelasan: Controller ini mengatur semua logika untuk manajemen keanggotaan,
// termasuk menampilkan data, memfilter, dan mengekspor ke Excel.

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CabangModel;
use App\Models\RantingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KeanggotaanController extends BaseController
{
    protected $userModel;
    protected $cabangModel;
    protected $rantingModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->cabangModel  = new CabangModel(); 
        $this->rantingModel = new RantingModel();
        helper(['form', 'url']);
    }

    // Menampilkan daftar anggota yang menunggu verifikasi
    public function index()
    {
        $data = [
            'title'      => 'Verifikasi Anggota',
            'page_title' => 'Verifikasi Anggota Baru',
            'users'      => $this->userModel->getUserDetailsByStatus('Menunggu Verifikasi')
        ];
        return view('verifikasi/index', $data);
    }

    // Proses untuk menyetujui pendaftaran
    public function setujui($id)
    {
        $this->userModel->update($id, ['status' => 'Aktif']);
        session()->setFlashdata('success', 'Anggota berhasil diverifikasi dan diaktifkan.');
        return redirect()->to('/verifikasi-anggota');
    }

    // Proses untuk menolak pendaftaran
    public function tolak($id)
    {
        $this->userModel->update($id, ['status' => 'Ditolak']);
        session()->setFlashdata('success', 'Pendaftaran anggota berhasil ditolak.');
        return redirect()->to('/verifikasi-anggota');
    }

    /**
     * FUNGSI DIPERBARUI: Menampilkan halaman manajemen anggota dengan filter.
     */
    public function manajemen()
    {
        $cabangId = $this->request->getGet('cabang_id');
        $isKokam = $this->request->getGet('is_kokam'); // Ambil parameter is_kokam

        $users = $this->userModel->getUserDetailsByStatus('Aktif', $cabangId, $isKokam); // Teruskan isKokam

        $data = [
            'title'           => 'Manajemen Anggota',
            'page_title'      => 'Daftar Anggota Aktif',
            'users'           => $users,
            'cabang_list'     => $this->cabangModel->findAll(),
            'selected_cabang' => $cabangId,
            'selected_kokam'  => $isKokam // Kirim ke view
        ];

        return view('keanggotaan/manajemen', $data);
    }

    /**
     * Menampilkan halaman edit data anggota.
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/manajemen-anggota')->with('error', 'Anggota tidak ditemukan.');
        }

        $rantingList = [];
        if (!empty($user['id_cabang'])) {
            $rantingList = $this->rantingModel->where('id_cabang', $user['id_cabang'])->findAll();
        }

        $data = [
            'title'        => 'Edit Anggota',
            'page_title'   => 'Edit Data Anggota: ' . $user['nama_lengkap'],
            'user'         => $user,
            'cabang_list'  => $this->cabangModel->findAll(),
            'ranting_list' => $rantingList,
        ];

        return view('keanggotaan/edit', $data);
    }

    /**
     * Memproses pembaruan data anggota.
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/manajemen-anggota')->with('error', 'Anggota tidak ditemukan.');
        }

        $emailRule = ($this->request->getPost('email') === $user['email']) 
            ? 'required|valid_email' 
            : "required|valid_email|is_unique[users.email,id,{$id}]";

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => $emailRule,
            'no_hp'        => 'permit_empty|numeric|min_length[10]',
            'nbm'          => 'permit_empty',
            'status'       => 'required|in_list[Aktif,Menunggu Verifikasi,Ditolak,Non-Aktif]',
            'foto'         => 'permit_empty|uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tipePimpinan = $this->request->getPost('tipe_pimpinan');
        $idCabang     = $this->request->getPost('id_cabang');
        $idRanting    = ($tipePimpinan === 'ranting') ? $this->request->getPost('id_ranting') : null;

        $updateData = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'email'         => $this->request->getPost('email'),
            'no_hp'         => $this->request->getPost('no_hp') ?: null,
            'nbm'           => $this->request->getPost('nbm') ?: null,
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir') ?: null,
            'alamat_rumah'  => $this->request->getPost('alamat_rumah') ?: null,
            'is_kokam'      => $this->request->getPost('is_kokam') ? 1 : 0,
            'status'        => $this->request->getPost('status'),
            'tipe_pimpinan' => $tipePimpinan ?: null,
            'id_cabang'     => $idCabang ?: null,
            'id_ranting'    => $idRanting ?: null,
            'jabatan'       => $this->request->getPost('jabatan') ?: null,
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if ($user['foto'] && $user['foto'] !== 'default.png' && file_exists(FCPATH . 'uploads/profil/' . $user['foto'])) {
                @unlink(FCPATH . 'uploads/profil/' . $user['foto']);
            }
            $newName = $fotoFile->getRandomName();
            $fotoFile->move(FCPATH . 'uploads/profil', $newName);
            $updateData['foto'] = $newName;
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/manajemen-anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * FUNGSI DIPERBARUI: Memproses ekspor data ke Excel dengan filter dan kolom baru.
     */
    public function export()
    {
        // ... (existing code)
    }

    /**
     * Menampilkan halaman untuk menghapus anggota.
     */
    public function hapus()
    {
        $cabangId = $this->request->getGet('cabang_id');
        $isKokam = $this->request->getGet('is_kokam');

        $users = $this->userModel->getUserDetailsByStatus('Aktif', $cabangId, $isKokam);

        $data = [
            'title'           => 'Hapus Anggota',
            'page_title'      => 'Hapus Anggota Aktif',
            'users'           => $users,
            'cabang_list'     => $this->cabangModel->findAll(),
            'selected_cabang' => $cabangId,
            'selected_kokam'  => $isKokam
        ];

        return view('keanggotaan/hapus', $data);
    }

    /**
     * Proses untuk menghapus anggota.
     */
    public function delete($id)
    {
        if (session()->get('id_role') != 1) { // Hanya Super Admin
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Anggota berhasil dihapus.');
        return redirect()->to('/manajemen-anggota/hapus');
    }
}
