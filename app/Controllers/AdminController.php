<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CabangModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $cabangModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->cabangModel = new CabangModel();
        helper(['form']);
    }

    /**
     * Menampilkan daftar semua pengguna dengan peran 'Admin'.
     */
    public function index()
    {
        $data = [
            'title'      => 'Manajemen Admin',
            'page_title' => 'Daftar Pengguna Admin',
            'admins'     => $this->userModel->getUserDetailsByRole('Admin')
        ];

        return view('admin/index', $data);
    }

    /**
     * Menampilkan form untuk membuat admin baru.
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah Admin Baru',
            'page_title' => 'Form Tambah Admin',
            'cabang'     => $this->cabangModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/create', $data);
    }

    /**
     * Menyimpan data admin baru ke database.
     */
    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'id_cabang'    => 'required|integer',
            'password'     => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_cabang'    => $this->request->getPost('id_cabang'),
            'id_role'      => 2, // ID untuk peran 'Admin'
            'status'       => 'Aktif',
        ]);

        return redirect()->to('/admin')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data admin.
     */
    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Admin',
            'page_title' => 'Form Edit Admin',
            'admin'      => $this->userModel->find($id),
            'cabang'     => $this->cabangModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/edit', $data);
    }

    /**
     * Memperbarui data admin di database.
     */
    public function update($id)
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => "required|valid_email|is_unique[users.email,id,{$id}]",
            'id_cabang'    => 'required|integer',
        ];
        
        // Validasi password hanya jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]'; // Changed from min_length[6] to required|min_length[6]
            $rules['pass_confirm'] = 'required|matches[password]'; // ADDED
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'id_cabang'    => $this->request->getPost('id_cabang'),
        ];

        // Update password hanya jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin')->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Menghapus admin dari database.
     */
    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin')->with('success', 'Data admin berhasil dihapus.');
    }
}
