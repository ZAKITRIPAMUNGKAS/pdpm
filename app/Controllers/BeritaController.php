<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        helper(['form', 'url', 'text']);
    }

    /**
     * Menampilkan daftar berita di area admin.
     */
    public function index()
    {
        $data = [
            'title'      => 'Manajemen Berita',
            'page_title' => 'Daftar Berita',
            'berita'     => $this->beritaModel->getBeritaWithPenulis()
        ];
        return view('berita/index', $data);
    }

    /**
     * Menampilkan form untuk menambah berita baru.
     */
    public function create()
    {
        $data = [
            'title'      => 'Tambah Berita Baru',
            'page_title' => 'Form Tambah Berita',
        ];
        return view('berita/create', $data);
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store()
    {
        $rules = [
            'judul'  => 'required|min_length[5]|is_unique[berita.judul]',
            'isi'    => 'required|min_length[20]',
            'gambar' => 'uploaded[gambar]|max_size[gambar,10240]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil file gambar
        $gambarFile = $this->request->getFile('gambar');
        // Generate nama random untuk file
        $namaGambar = $gambarFile->getRandomName();
        // Pindahkan file ke folder public/uploads/berita
        $gambarFile->move(FCPATH . 'uploads/berita', $namaGambar);

        $this->beritaModel->save([
            'judul'      => $this->request->getPost('judul'),
            'slug'       => url_title($this->request->getPost('judul'), '-', true),
            'isi'        => $this->request->getPost('isi', FILTER_UNSAFE_RAW),
            'gambar'     => $namaGambar,
            'id_penulis' => session()->get('user_id'),
        ]);

        return redirect()->to('/admin-berita')->with('success', 'Berita baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Berita',
            'page_title' => 'Form Edit Berita',
            'berita'     => $this->beritaModel->find($id)
        ];
        return view('berita/edit', $data);
    }

    /**
     * Memperbarui data berita di database.
     */
    public function update($id)
    {
        $beritaLama = $this->beritaModel->find($id);
        $judulRule = ($this->request->getPost('judul') == $beritaLama['judul']) ? 'required' : 'required|is_unique[berita.judul]';

        $rules = [
            'judul' => $judulRule,
            'isi'   => 'required|min_length[20]',
        ];

        // Validasi gambar hanya jika ada file baru yang diunggah
        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'max_size[gambar,10240]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGambar = $beritaLama['gambar'];
        $gambarFile = $this->request->getFile('gambar');

        // Jika ada gambar baru diunggah
        if ($gambarFile->isValid()) {
            // Hapus gambar lama
            if (file_exists('uploads/berita/' . $beritaLama['gambar'])) {
                unlink('uploads/berita/' . $beritaLama['gambar']);
            }
            // Generate nama baru dan pindahkan file
            $namaGambar = $gambarFile->getRandomName();
            $gambarFile->move(FCPATH . 'uploads/berita', $namaGambar);
        }

        $this->beritaModel->update($id, [
            'judul'  => $this->request->getPost('judul'),
            'slug'   => url_title($this->request->getPost('judul'), '-', true),
            'isi'    => $this->request->getPost('isi', FILTER_UNSAFE_RAW),
            'gambar' => $namaGambar,
        ]);

        return redirect()->to('/admin-berita')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function delete($id)
    {
        $berita = $this->beritaModel->find($id);

        // Hapus file gambar dari server
        if (file_exists('uploads/berita/' . $berita['gambar'])) {
            unlink('uploads/berita/' . $berita['gambar']);
        }

        $this->beritaModel->delete($id);
        return redirect()->to('/admin-berita')->with('success', 'Berita berhasil dihapus.');
    }
}
