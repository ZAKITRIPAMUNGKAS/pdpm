<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CabangModel;
use App\Models\RantingModel;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Memproses data login.
     */
    public function processLogin()
    {
        $session = session();
        $userModel = new UserModel();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/login')->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'Aktif') {
                $session->setFlashdata('error', 'Akun Anda belum aktif atau diblokir. Silakan hubungi admin.');
                return redirect()->to('/login');
            }

            $sessionData = [
                'user_id'      => $user['id'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email'],
                'id_role'      => $user['id_role'],
                'cabang_id'    => $user['id_cabang'] ?? null,
                'isLoggedIn'   => TRUE
            ];
            $session->set($sessionData);

            return redirect()->to('/dashboard');
        }

        $session->setFlashdata('error', 'Email atau Password salah.');
        return redirect()->to('/login');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function register()
    {
        $cabangModel = new CabangModel();
        $data['cabang'] = $cabangModel->findAll();
        return view('auth/register', $data);
    }

    /**
     * Memproses data registrasi.
     */
    public function processRegister()
    {
        $tipePimpinan = $this->request->getPost('tipe_pimpinan');
        $jabatan_utama = $this->request->getPost('jabatan_utama');

        // Define valid bidang options
        $validBidang = [
            'Organisasi & Keanggotaan',
            'Dakwah & Pengkajian Agama',
            'Pendidikan & Kaderisasi',
            'KOKAM & SAR',
            'Komunikasi, Informasi, Riset & Teknologi',
            'Ekonomi, Kewirausahaan, Buruh & Tani',
            'Hikmah & Hubungan antar Lembaga',
            'Seni Budaya, Olahraga & Pariwisata',
            'Hukum, HAM & Advokasi',
            'ESDM & Lingkungan Hidup'
        ];

        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'no_hp'        => 'required|min_length[10]|numeric',
            'nbm'          => 'permit_empty|numeric|min_length[5]|max_length[20]',
            'alamat_rumah' => 'required|min_length[10]|max_length[500]',
            'foto'         => 'permit_empty|uploaded[foto]|max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'tanggal_lahir'=> 'required|valid_date',
            'tipe_pimpinan'=> 'required|in_list[cabang,ranting,daerah]',
            'id_cabang'    => $tipePimpinan === 'daerah' ? 'permit_empty' : 'required|integer',
            'jabatan_organisasi'=> 'required|in_list[umum,harian,anggota]',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if ($tipePimpinan === 'ranting') {
            $rules['id_ranting'] = 'required|integer';
        }
        $jabatanOrganisasi = $this->request->getPost('jabatan_organisasi');
        $jabatanStruktural = $this->request->getPost('jabatan_struktural');

        if ($jabatanOrganisasi === 'umum') {
            $rules['jabatan_struktural'] = 'required|in_list[Ketua,Sekretaris,Bendahara,Wakil Bendahara]';
            $rules['jabatan_bidang'] = 'permit_empty';
        } elseif ($jabatanOrganisasi === 'harian') {
            $rules['jabatan_struktural'] = 'required|in_list[Wakil Ketua,Wakil Sekretaris]';
            if ($jabatanStruktural === 'Wakil Sekretaris') {
                $rules['jabatan_bidang'] = 'permit_empty';
            } else {
                // Use custom validation for bidang
                $rules['jabatan_bidang'] = 'required';
            }
        } elseif ($jabatanOrganisasi === 'anggota') {
            $rules['jabatan_struktural'] = 'permit_empty';
            // Use custom validation for bidang
            $rules['jabatan_bidang'] = 'required';
        }

        // Custom validation for jabatan_bidang
        if (($jabatanOrganisasi === 'harian' && $jabatanStruktural !== 'Wakil Sekretaris') || $jabatanOrganisasi === 'anggota') {
            $jabatanBidang = $this->request->getPost('jabatan_bidang');
            if (!in_array($jabatanBidang, $validBidang)) {
                return redirect()->to('/register')->withInput()->with('errors', ['jabatan_bidang' => 'Bidang yang dipilih tidak valid.']);
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses unggah foto
        $fotoFile = $this->request->getFile('foto');
        $namaFoto = 'default.png'; // Default value
        
        // Jika ada file foto yang diupload
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads/profil', $namaFoto);
        }

        // Gabungkan jabatan
        $jabatan_final = '';
        $jabatan_organisasi = $this->request->getPost('jabatan_organisasi');
        $jabatan_struktural = $this->request->getPost('jabatan_struktural');
        $jabatan_bidang = $this->request->getPost('jabatan_bidang');

        if ($jabatan_organisasi === 'umum') {
            $jabatan_final = $jabatan_struktural;
        } elseif ($jabatan_organisasi === 'harian') {
            $jabatan_final = $jabatan_struktural . ' Bidang ' . $jabatan_bidang;
        } elseif ($jabatan_organisasi === 'anggota') {
            $jabatan_final = $jabatan_bidang;
        }

        $userModel = new UserModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'nbm'          => $this->request->getPost('nbm') ? $this->request->getPost('nbm') : null,
            'alamat_rumah' => $this->request->getPost('alamat_rumah'),
            'foto'         => $namaFoto,
            'tanggal_lahir'=> $this->request->getPost('tanggal_lahir'),
            'is_kokam'     => $this->request->getPost('is_kokam') ? 1 : 0,
            'jabatan'      => $jabatan_final,
            'tipe_pimpinan'=> $tipePimpinan,
            'id_cabang'    => $this->request->getPost('id_cabang'),
            'id_ranting'   => $tipePimpinan === 'ranting' ? $this->request->getPost('id_ranting') : null,
            'jabatan_organisasi' => $jabatan_organisasi,
            'jabatan_struktural' => $jabatan_struktural,
            'jabatan_bidang' => $jabatan_bidang,
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_role'      => 3, // Default role for member
        ];

        $userModel->save($data);

        session()->setFlashdata('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi dari Admin.');
        return redirect()->to('/login');
    }

    /**
     * Mengambil data ranting berdasarkan cabang untuk AJAX.
     */
    public function getRantingByCabang($id_cabang)
    {
        $rantingModel = new RantingModel();
        $ranting = $rantingModel->where('id_cabang', $id_cabang)->findAll();
        return $this->response->setJSON($ranting);
    }

    /**
     * Proses logout.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
