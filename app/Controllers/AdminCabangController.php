<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CabangModel;
use App\Models\StrukturCabangModel; // Added for managing branch structure

class AdminCabangController extends BaseController
{
    protected $cabangModel;
    protected $strukturCabangModel; // Added for managing branch structure

    public function __construct()
    {
        $this->cabangModel = new CabangModel();
        $this->strukturCabangModel = new StrukturCabangModel(); // Initialize StrukturCabangModel
    }

    public function index()
    {
        // Get the cabang_id from the session
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            // Handle case where cabang_id is not in session (e.g., redirect to error or login)
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Fetch only the branch associated with the logged-in admin
        $cabang = $this->cabangModel->find($cabangId);

        if (!$cabang) {
            // Handle case where branch not found for the given ID
            return redirect()->to('/admin/dashboard')->with('error', 'Data cabang tidak ditemukan.');
        }

        // Redirect to the edit page for the specific branch
        return redirect()->to('/admin/cabang/edit');
    }

    public function edit()
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $cabang = $this->cabangModel->find($cabangId);

        if (!$cabang) {
            return redirect()->to('/admin/dashboard')->with('error', 'Data cabang tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Data Cabang',
            'page_title' => 'Edit Data Cabang Anda',
            'cabang'     => $cabang,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/cabang/edit', $data);
    }

    public function update()
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Validate input
        $rules = [
            'nama_cabang'        => 'required|min_length[3]|max_length[255]',
            'nama_ketua'         => 'required|min_length[3]|max_length[255]',
            'nama_sekretaris'    => 'required|min_length[3]|max_length[255]',
            'nama_bendahara'     => 'required|min_length[3]|max_length[255]',
            'cp_cabang'          => 'required|min_length[10]|max_length[15]',
            'email_cabang'       => 'required|valid_email',
            'alamat_sekretariat' => 'required|min_length[10]',
            'deskripsi_cabang'   => 'required|min_length[20]',
            'instagram'          => 'permit_empty|valid_url',
            'facebook'           => 'permit_empty|valid_url',
            'twitter'            => 'permit_empty|valid_url',
            'youtube'            => 'permit_empty|valid_url',
            'website'            => 'permit_empty|valid_url',
            'foto_sekretariat'   => 'max_size[foto_sekretariat,1024]|is_image[foto_sekretariat]|mime_in[foto_sekretariat,image/jpg,image/jpeg,image/png]|permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/cabang/edit')->withInput()->with('errors', $this->validator->getErrors());
        }

        $oldCabang = $this->cabangModel->find($cabangId);
        $fotoSekretariatName = $oldCabang['foto_sekretariat']; // Keep old image if no new one uploaded

        $fotoSekretariatFile = $this->request->getFile('foto_sekretariat');
        if ($fotoSekretariatFile && $fotoSekretariatFile->isValid() && !$fotoSekretariatFile->hasMoved()) {
            // Delete old image if it's not default.png
            if ($fotoSekretariatName && $fotoSekretariatName !== 'default.png' && file_exists('uploads/cabang/' . $fotoSekretariatName)) {
                unlink('uploads/cabang/' . $fotoSekretariatName);
            }
            $fotoSekretariatName = $fotoSekretariatFile->getRandomName();
            $fotoSekretariatFile->move('uploads/cabang', $fotoSekretariatName);
        }

        // Note: CabangModel does not have a 'slug' field in its allowedFields.
        // The public CabangController uses nama_cabang to generate slug on the fly or query.
        // So, we don't need to save 'slug' here.

        $data = [
            'nama_cabang'        => $this->request->getPost('nama_cabang'),
            'nama_ketua'         => $this->request->getPost('nama_ketua'),
            'nama_sekretaris'    => $this->request->getPost('nama_sekretaris'),
            'nama_bendahara'     => $this->request->getPost('nama_bendahara'),
            'cp_cabang'          => $this->request->getPost('cp_cabang'),
            'email_cabang'       => $this->request->getPost('email_cabang'),
            'alamat_sekretariat' => $this->request->getPost('alamat_sekretariat'),
            'deskripsi_cabang'   => $this->request->getPost('deskripsi_cabang'),
            'instagram'          => $this->request->getPost('instagram'),
            'facebook'           => $this->request->getPost('facebook'),
            'twitter'            => $this->request->getPost('twitter'),
            'youtube'            => $this->request->getPost('youtube'),
            'website'            => $this->request->getPost('website'),
            'foto_sekretariat'   => $fotoSekretariatName,
            'is_completed'       => true, // Mark as completed after update
        ];

        $this->cabangModel->update($cabangId, $data);

        session()->setFlashdata('success', 'Data cabang berhasil diperbarui.');
        return redirect()->to('/admin/cabang/edit');
    }

    // --- Struktur Cabang Management ---

    public function struktur()
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $strukturList = $this->strukturCabangModel->where('id_cabang', $cabangId)->findAll();

        $data = [
            'title'      => 'Manajemen Struktur Cabang',
            'page_title' => 'Struktur Cabang Anda',
            'struktur_list' => $strukturList,
        ];

        return view('admin/cabang/struktur/index', $data);
    }

    public function createStruktur()
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data = [
            'title'      => 'Tambah Struktur Cabang',
            'page_title' => 'Tambah Anggota Struktur',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/cabang/struktur/create', $data);
    }

    public function storeStruktur()
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $rules = [
            'nama'    => 'required|min_length[3]|max_length[255]',
            'jabatan' => 'required|min_length[3]|max_length[255]',
            'foto'    => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/cabang/struktur/create')->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = 'default.png';
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = $fotoFile->getRandomName();
            $fotoFile->move('uploads/struktur', $fotoName);
        }

        $data = [
            'id_cabang' => $cabangId,
            'nama'      => $this->request->getPost('nama'),
            'jabatan'   => $this->request->getPost('jabatan'),
            'foto'      => $fotoName,
            'status'    => 'aktif', // Add this line
        ];

        $this->strukturCabangModel->save($data);

        session()->setFlashdata('success', 'Anggota struktur berhasil ditambahkan.');
        return redirect()->to('/admin/cabang/struktur');
    }

    public function editStruktur($id)
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $struktur = $this->strukturCabangModel->where(['id' => $id, 'id_cabang' => $cabangId])->first();

        if (!$struktur) {
            return redirect()->to('/admin/cabang/struktur')->with('error', 'Data struktur tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $data = [
            'title'      => 'Edit Struktur Cabang',
            'page_title' => 'Edit Anggota Struktur',
            'struktur'   => $struktur,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/cabang/struktur/edit', $data);
    }

    public function updateStruktur($id)
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $struktur = $this->strukturCabangModel->where(['id' => $id, 'id_cabang' => $cabangId])->first();

        if (!$struktur) {
            return redirect()->to('/admin/cabang/struktur')->with('error', 'Data struktur tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'nama'    => 'required|min_length[3]|max_length[255]',
            'jabatan' => 'required|min_length[3]|max_length[255]',
            'foto'    => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/cabang/struktur/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = $struktur['foto'];
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            if ($fotoName && $fotoName !== 'default.png' && file_exists('uploads/struktur/' . $fotoName)) {
                unlink('uploads/struktur/' . $fotoName);
            }
            $fotoName = $fotoFile->getRandomName();
            $fotoFile->move('uploads/struktur', $fotoName);
        }

        $data = [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'foto'    => $fotoName,
            'status'  => 'aktif', // Add this line (or ensure it remains aktif if it was)
        ];

        $this->strukturCabangModel->update($id, $data);

        session()->setFlashdata('success', 'Anggota struktur berhasil diperbarui.');
        return redirect()->to('/admin/cabang/struktur');
    }

    public function deleteStruktur($id)
    {
        $cabangId = session()->get('cabang_id');

        if (!$cabangId) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $struktur = $this->strukturCabangModel->where(['id' => $id, 'id_cabang' => $cabangId])->first();

        if (!$struktur) {
            return redirect()->to('/admin/cabang/struktur')->with('error', 'Data struktur tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Delete photo if it's not default.png
        if ($struktur['foto'] && $struktur['foto'] !== 'default.png' && file_exists('uploads/struktur/' . $struktur['foto'])) {
            unlink('uploads/struktur/' . $struktur['foto']);
        }

        $this->strukturCabangModel->delete($id);

        session()->setFlashdata('success', 'Anggota struktur berhasil dihapus.');
        return redirect()->to('/admin/cabang/struktur');
    }
}