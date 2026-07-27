<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\AgendaModel;
use App\Models\GaleriModel;
use App\Models\UserModel;
use App\Models\CabangModel;
use App\Models\RantingModel;

class HomeController extends BaseController
{
    protected $beritaModel;
    protected $agendaModel;
    protected $galeriModel;
    protected $cache;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->agendaModel = new AgendaModel();
        $this->galeriModel = new GaleriModel();
        $this->cache = \Config\Services::cache();
        helper(['text', 'cache']); 
    }

    /**
     * Menampilkan halaman beranda.
     */
    public function index()
    {
        $userModel = new UserModel();
        $cabangModel = new CabangModel();
        $rantingModel = new RantingModel();

        // Statistik umum
        $totalAnggota = $userModel->where('status', 'Aktif')->whereNotIn('id_role', [1, 2])->countAllResults();
        $totalCabang = $userModel->select('COUNT(DISTINCT id_cabang) as count')->where('status', 'Aktif')->whereNotIn('id_role', [1, 2])->get()->getRow()->count;
        $totalRanting = $userModel->select('COUNT(DISTINCT id_ranting) as count')->where('status', 'Aktif')->whereNotIn('id_role', [1, 2])->where('id_ranting IS NOT NULL')->get()->getRow()->count;
        $totalKokam = $userModel->where('status', 'Aktif')->where('is_kokam', 1)->whereNotIn('id_role', [1, 2])->countAllResults();

        // Statistik per cabang
        $statistikCabang = $userModel->select('cabang.nama_cabang, COUNT(users.id) as jumlah_anggota')
                                    ->join('cabang', 'cabang.id = users.id_cabang')
                                    ->where('users.status', 'Aktif')
                                    ->whereNotIn('users.id_role', [1, 2]) // Tambahkan ini
                                    ->where('users.id_cabang IS NOT NULL') // ADDED THIS LINE
                                    ->where('cabang.nama_cabang IS NOT NULL') // ADDED THIS LINE
                                    ->groupBy('users.id_cabang')
                                    ->orderBy('jumlah_anggota', 'DESC')
                                    ->findAll();

        // Statistik per ranting (top 10)
        $statistikRanting = $userModel->select('ranting.nama_ranting, cabang.nama_cabang, COUNT(users.id) as jumlah_anggota')
                                     ->join('ranting', 'ranting.id = users.id_ranting')
                                     ->join('cabang', 'cabang.id = users.id_cabang')
                                     ->where('users.status', 'Aktif')
                                     ->whereNotIn('users.id_role', [1, 2]) // Tambahkan ini
                                     ->where('users.id_ranting IS NOT NULL')
                                     ->groupBy('users.id_ranting')
                                     ->orderBy('jumlah_anggota', 'DESC')
                                     ->limit(10)
                                     ->findAll();

        // Berita terbaru (limit 6)
        $beritaTerbaru = $this->beritaModel->getBeritaWithPenulis(6);

        // Agenda mendatang (limit 3)
        $agendaMendatang = $this->agendaModel->where('tanggal_mulai >=', date('Y-m-d'))
                                           ->orderBy('tanggal_mulai', 'ASC')
                                           ->limit(3)
                                           ->findAll();

        $data = [
            'title'            => 'Selamat Datang di Website PDPM Karanganyar',
            'totalAnggota'     => $totalAnggota,
            'totalCabang'      => $totalCabang,
            'totalRanting'     => $totalRanting,
            'totalKokam'       => $totalKokam,
            'statistikCabang'  => $statistikCabang,
            'statistikRanting' => $statistikRanting,
            'berita'           => $beritaTerbaru,
            'agenda'           => $agendaMendatang
        ];
        return view('public/home', $data);
    }

    /**
     * Menampilkan halaman daftar berita.
     */
    public function berita()
    {
        $data = [
            'title'  => 'Berita Terbaru - PDPM Karanganyar',
            'berita' => $this->beritaModel->getBeritaWithPenulis()
        ];
        return view('public/berita', $data);
    }

    /**
     * Menampilkan detail berita.
     */
    public function beritaDetail($slug)
    {
        $artikel = $this->beritaModel->getBeritaBySlug($slug);

        if (empty($artikel)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita dengan slug: ' . $slug . ' tidak ditemukan.');
        }

        // Siapkan untuk OG Meta Tags
        $deskripsi = character_limiter(strip_tags($artikel['isi']), 155);
        $thumbnail = base_url('uploads/berita/' . $artikel['gambar']);

        $data = [
            'title'     => esc($artikel['judul']),
            'berita'    => $artikel,
            'deskripsi' => esc($deskripsi),
            'thumbnail' => esc($thumbnail)
        ];
        return view('public/berita_detail', $data);
    }

    /**
     * Menampilkan halaman agenda.
     */
    public function agenda()
    {
        $data = [
            'title'  => 'Agenda Kegiatan - PDPM Karanganyar',
            'agenda' => $this->agendaModel->getAgendaWithPenulis()
        ];
        return view('public/agenda', $data);
    }

    /**
     * Menampilkan halaman galeri.
     */
    public function galeri()
    {
        $kategori = $this->request->getGet('kategori');
        
        $db = \Config\Database::connect();
        $builder = $db->table('galeri');
        $builder->select('galeri.*, COALESCE(users.nama_lengkap, "Admin") as nama_penulis');
        $builder->join('users', 'users.id = galeri.id_penulis', 'left');
        
        if ($kategori && in_array($kategori, ['kegiatan', 'rapat', 'pelatihan', 'lainnya'])) {
            $builder->where('galeri.kategori', $kategori);
        }
        
        $builder->orderBy('galeri.created_at', 'DESC');
        
        $data = [
            'title'    => 'Galeri Kegiatan - PDPM Karanganyar',
            'galeri'   => $builder->get()->getResultArray(),
            'kategori' => $kategori
        ];
        return view('public/galeri', $data);
    }

    

    /**
     * Menampilkan halaman profil organisasi.
     */
    public function profil()
    {
        $data = [
            'title' => 'Profil Organisasi - PDPM Karanganyar'
        ];
        return view('public/profil', $data);
    }

    /**
     * FUNGSI BARU: Menampilkan halaman kontak.
     */
    public function kontak()
    {
        $data = [
            'title' => 'Kontak Kami - PDPM Karanganyar'
        ];
        return view('public/kontak', $data);
    }
}
