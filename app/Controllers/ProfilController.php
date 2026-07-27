<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserPointsModel;

class ProfilController extends BaseController
{
    protected $userModel;
    protected $pointsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pointsModel = new UserPointsModel();
        helper(['form']);
    }

    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->getUserDetails($userId);

        // PENGECEKAN PENTING: Jika user tidak ditemukan, hancurkan sesi dan redirect.
        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda tidak valid. Silakan login kembali.');
        }

        $data = [
            'title'      => 'Profil Saya',
            'page_title' => 'Ubah Profil Saya',
            'user'       => $user
        ];

        return view('profil/index', $data);
    }

    /**
     * FUNGSI BARU: Menampilkan halaman profil publik.
     */
    public function public_profil()
    {
        $data = [
            'title' => 'Profil Organisasi - PDPM Karanganyar',
        ];
        return view('public/profil', $data);
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        // Aturan validasi email: harus unik, kecuali untuk email pengguna saat ini.
        $emailRule = ($this->request->getPost('email') == $user['email']) ? 'required|valid_email' : "required|valid_email|is_unique[users.email,id,{$userId}]";

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => $emailRule,
            'nbm'          => 'permit_empty|alpha_numeric|max_length[50]',
            'no_hp'        => 'permit_empty|numeric|max_length[15]',
            'alamat_rumah' => 'required|min_length[10]|max_length[500]',
        ];

        // Tambahkan aturan validasi untuk password hanya jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['pass_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'nbm'          => $this->request->getPost('nbm') ?: null,
            'no_hp'        => $this->request->getPost('no_hp') ?: null,
            'alamat_rumah' => $this->request->getPost('alamat_rumah'),
        ];

        // Perbarui password hanya jika kolom password diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        // Cek apakah profil sudah lengkap dan berikan poin jika belum pernah mendapatkannya
        $this->checkAndGiveProfileCompletionPoints($userId, $data);

        // Perbarui juga session nama_lengkap jika berubah
        session()->set('nama_lengkap', $data['nama_lengkap']);

        return redirect()->to('/profil-saya')->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Memperbarui foto profil pengguna.
     */
    public function update_foto()
    {
        $userId = session()->get('user_id');

        $rules = [
            'foto' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('foto');

        if ($img->isValid() && !$img->hasMoved()) {
            // Hapus foto lama jika bukan default
            $user = $this->userModel->find($userId);
            if ($user['foto'] && $user['foto'] != 'default.png' && file_exists(FCPATH . 'uploads/profil/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $user['foto']);
            }

            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/profil', $newName);

            $this->userModel->update($userId, ['foto' => $newName]);

            // Cek apakah profil sudah lengkap dan berikan poin jika belum pernah mendapatkannya
            $user = $this->userModel->find($userId);
            $this->checkAndGiveProfileCompletionPoints($userId, $user);

            return redirect()->to('/profil-saya')->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->to('/profil-saya')->with('error', 'Gagal mengunggah foto.');
    }

    /**
     * Cek apakah profil sudah lengkap dan berikan poin jika belum pernah mendapatkannya
     */
    private function checkAndGiveProfileCompletionPoints($userId, $userData)
    {
        // Field yang diperlukan untuk profil lengkap
        $requiredFields = ['nama_lengkap', 'email', 'no_hp', 'alamat_rumah', 'foto'];
        
        $isComplete = true;
        foreach ($requiredFields as $field) {
            if (empty($userData[$field]) || $userData[$field] === 'default.png') {
                $isComplete = false;
                break;
            }
        }

        // Jika profil lengkap dan belum pernah mendapat poin untuk melengkapi profil
        if ($isComplete && !$this->pointsModel->sudahDapatPoin($userId, UserPointsModel::AKTIVITAS_LENGKAPI_PROFIL)) {
            $this->pointsModel->prosesPoinOtomatis($userId, UserPointsModel::AKTIVITAS_LENGKAPI_PROFIL);
        }
    }
}
