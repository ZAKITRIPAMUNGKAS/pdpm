<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class GaleriController extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        helper(['form', 'url']);
    }

    /**
     * Menampilkan halaman manajemen galeri.
     */
    public function index()
    {
        $data = [
            'title'      => 'Manajemen Galeri',
            'page_title' => 'Galeri Foto Kegiatan',
            'galeri'     => $this->galeriModel->getGaleriWithPenulis()
        ];
        return view('galeri/index', $data);
    }

    /**
     * Menyimpan foto baru ke database dan server.
     */
    public function store()
    {
        $rules = [
            'judul'    => 'required|min_length[3]',
            'kategori' => 'required|in_list[kegiatan,rapat,pelatihan,lainnya]',
            'gambar'   => 'uploaded[gambar]|max_size[gambar,10240]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarFile = $this->request->getFile('gambar');
        $namaGambar = $gambarFile->getRandomName();
        $gambarFile->move('uploads/galeri', $namaGambar);

        $dataToSave = [
            'judul'      => $this->request->getPost('judul'),
            'file_path'  => $namaGambar,
            'tipe'       => 'foto',
            'kategori'   => $this->request->getPost('kategori'),
            'id_penulis' => session()->get('user_id'),
        ];

        $this->galeriModel->save($dataToSave);

        return redirect()->to('/admin-galeri')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    /**
     * Menghapus foto dari database dan server.
     */
    public function delete($id)
    {
        $foto = $this->galeriModel->find($id);

        if ($foto) {
            $filePath = 'uploads/galeri/' . $foto['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $this->galeriModel->delete($id);
            return redirect()->to('/admin-galeri')->with('success', 'Foto berhasil dihapus dari galeri.');
        }

        return redirect()->to('/admin-galeri')->with('error', 'Foto tidak ditemukan.');
    }
}

