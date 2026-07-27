<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\AgendaPesertaModel;
use App\Models\AbsensiKegiatanModel;
use App\Models\UserPointsModel;
use App\Helpers\GpsHelper;

class AbsensiController extends BaseController
{
    protected $agendaModel;
    protected $pesertaModel;
    protected $absensiModel;
    protected $pointsModel;

    public function __construct()
    {
        $this->agendaModel = new AgendaModel();
        $this->pesertaModel = new AgendaPesertaModel();
        $this->absensiModel = new AbsensiKegiatanModel();
        $this->pointsModel = new UserPointsModel();
        helper(['form', 'url', 'text']);
    }

    /**
     * Halaman daftar agenda untuk anggota.
     */
    public function daftarAgenda()
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        try {
            // Ambil semua agenda yang akan datang
            $agendaList = $this->agendaModel->where('tanggal_mulai >=', date('Y-m-d'))
                                           ->orderBy('tanggal_mulai', 'ASC')
                                           ->findAll();

            // Tambahkan info pendaftaran dan jumlah peserta
            foreach ($agendaList as &$agenda) {
                $agenda['sudah_daftar'] = $this->pesertaModel->isUserRegistered($agenda['id'], $userId);
                $agenda['jumlah_peserta'] = $this->pesertaModel->countPeserta($agenda['id']);
                $agenda['sudah_absen'] = $this->absensiModel->isUserAbsen($agenda['id'], $userId);
                
                // Format tanggal untuk tampilan
                $agenda['tanggal_formatted'] = date('d M Y', strtotime($agenda['tanggal_mulai']));
                $agenda['waktu_formatted'] = date('H:i', strtotime($agenda['jam_mulai'])) . ' - ' . date('H:i', strtotime($agenda['jam_selesai']));
            }

            $data = [
                'title' => 'Daftar Agenda Kegiatan',
                'page_title' => 'Agenda Kegiatan',
                'agenda' => $agendaList
            ];

            return view('absensi/daftar_agenda', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in daftarAgenda: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data agenda.');
        }
    }

    /**
     * Detail agenda dan form pendaftaran.
     */
    public function detailAgenda($id)
    {
        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
        }

        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $sudahDaftar = $this->pesertaModel->isUserRegistered($id, $userId);
            $sudahAbsen = $this->absensiModel->isUserAbsen($id, $userId);
            
            // Cek apakah bisa absen (sudah daftar, belum absen, dan dalam waktu yang tepat)
            $bisaAbsen = false;
            $pesanWaktu = '';
            
            // Jika user belum terdaftar namun ingin absen/daftar langsung, atau Admin/Super Admin
            $isAdmin = in_array(session()->get('id_role'), [1, 2]);
            
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $tanggalMulai = new \DateTime($agenda['tanggal_mulai']);
            $tanggalSelesai = !empty($agenda['tanggal_selesai']) ? new \DateTime($agenda['tanggal_selesai']) : clone $tanggalMulai;
            if (empty($agenda['tanggal_selesai'])) {
                $tanggalSelesai->setTime(23, 59, 59);
            }
            
            // Waktu absensi fleksibel: dibuka dari hari H atau untuk Admin
            if (!$sudahAbsen) {
                if ($isAdmin || ($now >= $tanggalMulai && $now <= $tanggalSelesai)) {
                    $bisaAbsen = true;
                } elseif ($now < $tanggalMulai) {
                    $pesanWaktu = 'Absensi dibuka saat acara dimulai (' . $tanggalMulai->format('d/m/Y H:i') . ')';
                } else {
                    $pesanWaktu = 'Absensi telah ditutup pada ' . $tanggalSelesai->format('d/m/Y H:i');
                }
            }
            
            // Ambil status absen jika sudah absen
            $statusAbsen = '';
            $waktuAbsen = '';
            if ($sudahAbsen) {
                $absensiData = $this->absensiModel->where('id_agenda', $id)
                                                ->where('id_user', $userId)
                                                ->first();
                if ($absensiData) {
                    $statusAbsen = ucfirst($absensiData['status_absen']);
                    $waktuAbsen = date('d/m/Y H:i:s', strtotime($absensiData['waktu_absen']));
                }
            }
            
            $absensiList = $this->absensiModel->getAbsensiByAgenda($id);

            $data = [
                'title' => 'Detail Agenda - ' . $agenda['nama_kegiatan'],
                'page_title' => 'Detail Agenda',
                'agenda' => $agenda,
                'sudah_daftar' => $sudahDaftar,
                'jumlah_peserta' => $this->pesertaModel->countPeserta($id),
                'sudah_absen' => $sudahAbsen,
                'bisa_absen' => $bisaAbsen,
                'status_absen' => $statusAbsen,
                'waktu_absen' => $waktuAbsen,
                'pesan_waktu' => $pesanWaktu,
                'peserta_list' => $this->pesertaModel->getPesertaByAgenda($id),
                'absensi_list' => $absensiList,
                'jumlah_absen' => count($absensiList)
            ];

            return view('absensi/detail_agenda', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in detailAgenda: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat detail agenda.');
        }
    }

    /**
     * Proses pendaftaran ke agenda.
     */
    public function daftarKeAgenda($id)
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        try {
            // Cek apakah agenda ada
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                return redirect()->back()->with('error', 'Agenda tidak ditemukan.');
            }

            // Cek apakah sudah terdaftar
            if ($this->pesertaModel->isUserRegistered($id, $userId)) {
                return redirect()->back()->with('error', 'Anda sudah terdaftar di agenda ini.');
            }

            // Cek apakah agenda masih bisa didaftari (belum dimulai)
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $tanggalMulai = new \DateTime($agenda['tanggal_mulai']);
            
            if ($now >= $tanggalMulai) {
                return redirect()->back()->with('error', 'Pendaftaran sudah ditutup karena agenda telah dimulai.');
            }

            // Daftarkan user
            $result = $this->pesertaModel->daftarKeAgenda($id, $userId);
            if ($result['success']) {
                return redirect()->back()->with('success', 'Berhasil mendaftar ke agenda: ' . $agenda['nama_kegiatan']);
            } else {
                return redirect()->back()->with('error', $result['message'] ?? 'Gagal mendaftar ke agenda. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in daftarKeAgenda: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar ke agenda.');
        }
    }

    /**
     * Batalkan pendaftaran dari agenda.
     */
    public function batalkanPendaftaran($id)
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        try {
            // Cek apakah agenda ada
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                return redirect()->back()->with('error', 'Agenda tidak ditemukan.');
            }

            // Cek apakah sudah absen (tidak bisa batal jika sudah absen)
            if ($this->absensiModel->isUserAbsen($id, $userId)) {
                return redirect()->back()->with('error', 'Tidak dapat membatalkan pendaftaran karena Anda sudah melakukan absensi.');
            }

            // Cek apakah agenda sudah dimulai (tidak bisa batal jika sudah dimulai)
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $tanggalMulai = new \DateTime($agenda['tanggal_mulai']);
            
            if ($now >= $tanggalMulai) {
                return redirect()->back()->with('error', 'Tidak dapat membatalkan pendaftaran karena agenda telah dimulai.');
            }

            if ($this->pesertaModel->batalkanPendaftaran($id, $userId)) {
                return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
            } else {
                return redirect()->back()->with('error', 'Gagal membatalkan pendaftaran.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in batalkanPendaftaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan pendaftaran.');
        }
    }

    /**
     * Halaman absensi dengan GPS tracking.
     */
    public function absensi($id)
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        try {
            // Cek agenda
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
            }

            // Cek apakah user terdaftar
            if (!$this->pesertaModel->isUserRegistered($id, $userId)) {
                return redirect()->to('/absensi/agenda')->with('error', 'Anda belum terdaftar di agenda ini.');
            }

            // Cek apakah sudah absen
            if ($this->absensiModel->isUserAbsen($id, $userId)) {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Anda sudah melakukan absensi di agenda ini.');
            }

            // Cek apakah agenda sedang berlangsung
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $tanggalMulai = new \DateTime($agenda['tanggal_mulai']);
            $tanggalSelesai = new \DateTime($agenda['tanggal_selesai']);

            if ($now < $tanggalMulai) {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Absensi belum dibuka. Akan dibuka pada: ' . $tanggalMulai->format('d/m/Y H:i'));
            }

            if ($now > $tanggalSelesai) {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Absensi sudah ditutup pada: ' . $tanggalSelesai->format('d/m/Y H:i'));
            }

            $data = [
                'title' => 'Absensi - ' . $agenda['nama_kegiatan'],
                'page_title' => 'Absensi Kegiatan',
                'agenda' => $agenda
            ];

            return view('absensi/form_absensi', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in absensi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman absensi.');
        }
    }

    /**
     * Proses absensi dengan validasi GPS.
     */
    public function prosesAbsensi()
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
        }

        try {
            $agendaId = $this->request->getPost('id_agenda');
            $userLat = (float) $this->request->getPost('latitude');
            $userLon = (float) $this->request->getPost('longitude');
            $keterangan = $this->request->getPost('keterangan');

            // Validasi input
            if (empty($agendaId) || empty($userLat) || empty($userLon)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data GPS tidak lengkap. Pastikan GPS aktif dan izinkan akses lokasi.'
                ]);
            }

            // Ambil data agenda
            $agenda = $this->agendaModel->find($agendaId);
            if (!$agenda) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Agenda tidak ditemukan.'
                ]);
            }

            // Cek apakah user terdaftar
            if (!$this->pesertaModel->isUserRegistered($agendaId, $userId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda belum terdaftar di agenda ini.'
                ]);
            }

            // Cek apakah sudah absen
            if ($this->absensiModel->isUserAbsen($agendaId, $userId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi di agenda ini.'
                ]);
            }

            // Validasi lokasi GPS
            $validasi = GpsHelper::isWithinRadius(
                $userLat, 
                $userLon, 
                (float) $agenda['latitude'], 
                (float) $agenda['longitude'], 
                (int) $agenda['radius_meter']
            );

            if (!$validasi['valid']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $validasi['message'],
                    'distance' => $validasi['distance']
                ]);
            }

            // Tentukan status absen (hadir/terlambat)
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $batasWaktu = new \DateTime($agenda['tanggal_mulai']);
            $statusAbsen = ($now <= $batasWaktu) ? 'hadir' : 'terlambat';

            // Simpan absensi
            $dataAbsensi = [
                'id_agenda' => $agendaId,
                'id_user' => $userId,
                'waktu_absen' => $now->format('Y-m-d H:i:s'),
                'latitude_absen' => $userLat,
                'longitude_absen' => $userLon,
                'jarak_meter' => $validasi['distance'],
                'status_absen' => $statusAbsen,
                'keterangan' => $keterangan
            ];

            if ($this->absensiModel->simpanAbsensi($dataAbsensi)) {
                // Berikan poin berdasarkan status absensi
                $jenisAktivitas = ($statusAbsen === 'hadir') ? 
                    UserPointsModel::AKTIVITAS_HADIR_TEPAT_WAKTU : 
                    UserPointsModel::AKTIVITAS_HADIR_TERLAMBAT;
                
                $this->pointsModel->prosesPoinOtomatis($userId, $jenisAktivitas, $agendaId);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Absensi berhasil! Status: ' . ucfirst($statusAbsen),
                    'status' => $statusAbsen,
                    'distance' => $validasi['distance'],
                    'waktu' => $now->format('d/m/Y H:i:s')
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data absensi. Silakan coba lagi.'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in prosesAbsensi: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Riwayat absensi user.
     */
    public function riwayatAbsensi()
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        try {
            $data = [
                'title' => 'Riwayat Absensi',
                'page_title' => 'Riwayat Absensi Saya',
                'riwayat' => $this->absensiModel->getRiwayatAbsensiUser($userId),
                'total_kehadiran' => $this->absensiModel->getTotalKehadiranUser($userId)
            ];

            return view('absensi/riwayat', $data);
        } catch (\Exception $e) {
            log_message('error', 'Error in riwayatAbsensi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi.');
        }
    }

    /**
     * Rekap absensi untuk admin.
     */
    public function rekapAbsensi($id = null)
    {
        // Hanya admin yang bisa akses
        if (!in_array(session()->get('id_role'), [1, 2])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan.');
        }

        try {
            if ($id) {
                // Detail rekap per agenda
                $agenda = $this->agendaModel->find($id);
                if (!$agenda) {
                    throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
                }

                $data = [
                    'title' => 'Rekap Absensi - ' . $agenda['nama_kegiatan'],
                    'page_title' => 'Rekap Absensi Kegiatan',
                    'agenda' => $agenda,
                    'absensi_list' => $this->absensiModel->getAbsensiWithGpsAnalysis($id),
                    'statistik' => $this->absensiModel->getStatistikAbsensi($id),
                    'peserta_list' => $this->pesertaModel->getPesertaByAgenda($id)
                ];

                return view('absensi/rekap_detail', $data);
            } else {
                // Daftar semua agenda untuk rekap
                $data = [
                    'title' => 'Rekap Absensi',
                    'page_title' => 'Rekap Absensi Kegiatan',
                    'agenda_list' => $this->agendaModel->getAgendaWithAbsensiStats()
                ];

                return view('absensi/rekap_list', $data);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in rekapAbsensi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat rekap absensi.');
        }
    }

    /**
     * Export data absensi ke Excel/CSV.
     */
    public function exportAbsensi($id)
    {
        // Hanya admin yang bisa akses
        if (!in_array(session()->get('id_role'), [1, 2])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan.');
        }

        try {
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan.');
            }

            $dataExport = $this->absensiModel->getDataExport($id);
            
            // Set header untuk download CSV
            $filename = 'absensi_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $agenda['nama_kegiatan']) . '_' . date('Y-m-d') . '.csv';
            
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($output, [
                'Nama Lengkap',
                'Email', 
                'No HP',
                'Waktu Absen',
                'Status Absen',
                'Jarak (meter)',
                'Keterangan',
                'Nama Kegiatan',
                'Tanggal Kegiatan',
                'Lokasi'
            ]);
            
            // Data CSV
            foreach ($dataExport as $row) {
                fputcsv($output, [
                    $row['nama_lengkap'],
                    $row['email'],
                    $row['no_hp'],
                    $row['waktu_absen'],
                    ucfirst($row['status_absen']),
                    $row['jarak_meter'],
                    $row['keterangan'] ?? '-',
                    $row['nama_kegiatan'],
                    date('d/m/Y', strtotime($row['tanggal_mulai'])),
                    $row['lokasi']
                ]);
            }
            
            fclose($output);
            exit;
        } catch (\Exception $e) {
            log_message('error', 'Error in exportAbsensi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export data absensi.');
        }
    }

    /**
     * Join agenda via GET (untuk tombol Gabung Sekarang).
     */
    public function joinAgenda($id)
    {
        // Fix: gunakan id_user yang benar dari session
        $userId = session()->get('id_user') ?? session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                return redirect()->to('/absensi/agenda')->with('error', 'Agenda tidak ditemukan.');
            }

            // Cek apakah sudah terdaftar
            if ($this->pesertaModel->isUserRegistered($id, $userId)) {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Anda sudah terdaftar di agenda ini.');
            }

            // Cek apakah agenda masih bisa didaftari (belum dimulai)
            $now = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $tanggalMulai = new \DateTime($agenda['tanggal_mulai']);
            if ($now >= $tanggalMulai) {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Pendaftaran sudah ditutup karena agenda telah dimulai.');
            }

            // Daftarkan user
            $result = $this->pesertaModel->daftarKeAgenda($id, $userId);
            if ($result['success']) {
                return redirect()->to('/absensi/agenda/' . $id)->with('success', 'Berhasil mendaftar ke agenda: ' . $agenda['nama_kegiatan']);
            } else {
                return redirect()->to('/absensi/agenda/' . $id)->with('error', $result['message'] ?? 'Gagal mendaftar ke agenda. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error in joinAgenda: ' . $e->getMessage());
            return redirect()->to('/absensi/agenda/' . $id)->with('error', 'Terjadi kesalahan saat mendaftar ke agenda.');
        }
    }
}
