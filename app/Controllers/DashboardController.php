<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\BeritaModel;
use App\Models\AgendaModel;
use App\Models\GaleriModel;
use App\Models\CabangModel;
use App\Models\RantingModel;
use App\Models\AbsensiKegiatanModel;
use App\Models\AgendaPesertaModel;
use App\Models\UserPointsModel;
use App\Models\VotingModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $beritaModel;
    protected $agendaModel;
    protected $galeriModel;
    protected $cabangModel;
    protected $rantingModel;
    protected $absensiModel;
    protected $pesertaModel;
    protected $pointsModel;
    protected $votingModel;

    public function __construct()
    {
        helper('text');
        $this->userModel    = new UserModel();
        $this->beritaModel  = new BeritaModel();
        $this->agendaModel  = new AgendaModel();
        $this->galeriModel  = new GaleriModel();
        $this->cabangModel  = new CabangModel();
        $this->rantingModel = new RantingModel();
        $this->absensiModel = new AbsensiKegiatanModel();
        $this->pesertaModel = new AgendaPesertaModel();
        $this->pointsModel  = new UserPointsModel();
        $this->votingModel  = new VotingModel();
    }

    public function index()
    {
        $userRole = session()->get('id_role');
        $userId   = session()->get('user_id');

        $data = [
            'title'      => 'Dashboard - PDPM Karanganyar',
            'page_title' => 'Dashboard',
            'user_name'  => session()->get('nama_lengkap'),
        ];

        switch ($userRole) {
            case 1:
                $data += $this->getSuperAdminData();
                break;
            case 2:
                $data += $this->getAdminData();
                break;
            default:
                $data += $this->getAnggotaData($userId);
        }

        return view('dashboard/index', $data);
    }

    

    private function getSuperAdminData()
    {
        $totalAnggota = $this->userModel->where('status', 'Aktif')->countAllResults();
        $statistikCabang = [];
        if ($totalAnggota > 0) {
            // Only get users WITH branches (exclude NULL/empty branches)
            $statistikCabang = $this->userModel
                ->select('cabang.nama_cabang, COUNT(users.id) as jumlah_anggota')
                ->join('cabang', 'cabang.id = users.id_cabang', 'inner') // Changed from 'left' to 'inner' to exclude NULL
                ->where('users.status', 'Aktif')
                ->where('users.id_cabang IS NOT NULL')
                ->where('users.id_cabang !=', 0)
                ->groupBy('users.id_cabang')
                ->orderBy('jumlah_anggota', 'DESC')
                ->limit(5)
                ->findAll();
        }

        // Adjusted totalCabang and totalRanting to match HomeController
        $totalCabang = $this->userModel->select('COUNT(DISTINCT id_cabang) as count')
                                       ->where('status', 'Aktif')
                                       ->whereNotIn('id_role', [1, 2])
                                       ->get()->getRow()->count;
        $totalRanting = $this->userModel->select('COUNT(DISTINCT id_ranting) as count')
                                        ->where('status', 'Aktif')
                                        ->whereNotIn('id_role', [1, 2])
                                        ->where('id_ranting IS NOT NULL')
                                        ->get()->getRow()->count;

        // NEW: Get agenda with attendance statistics
        $agendaWithAbsensi = $this->agendaModel->getAgendaWithAbsensiStats();

        // NEW: Get voting statistics
        $votingStats = $this->votingModel->getDashboardStats();

        return [
            'dashboard_type'    => 'super_admin',
            'totalAnggota'      => $totalAnggota,
            'totalBerita'       => $this->beritaModel->countAllResults(),
            'totalAgenda'       => $this->agendaModel->countAllResults(),
            'totalGaleri'       => $this->galeriModel->countAllResults(),
            'totalCabang'       => $totalCabang, // Use the adjusted value
            'totalRanting'      => $totalRanting, // Use the adjusted value
            'pendingVerifikasi' => $this->userModel->where('status', 'Menunggu Verifikasi')->countAllResults(),
            'totalAdmin'        => $this->userModel->where('id_role', 2)->countAllResults(),
            'recentBerita'      => $this->beritaModel->orderBy('created_at', 'DESC')->limit(3)->find(),
            'recentAnggota'     => $this->userModel->where('status', 'Aktif')->where('jabatan_organisasi', 'anggota')->orderBy('created_at', 'DESC')->limit(3)->find(),
            'statistikCabang'   => $statistikCabang,
            'agendaWithAbsensi' => $agendaWithAbsensi, // NEW: Add agenda with attendance data
            'votingStats'       => $votingStats, // NEW: Add voting statistics
        ];
    }

    private function getAdminData()
    {
        return [
            'dashboard_type'    => 'admin',
            'totalAnggota'      => $this->userModel->where('status', 'Aktif')->countAllResults(),
            'totalBerita'       => $this->beritaModel->countAllResults(),
            'totalAgenda'       => $this->agendaModel->countAllResults(),
            'pendingVerifikasi' => $this->userModel->where('status', 'Menunggu Verifikasi')->countAllResults(),
        ];
    }

    private function getAnggotaData($userId)
    {
        $userProfile = $this->userModel->find($userId);
        
        // Data untuk sidebar
        $sidebarData = $this->getSidebarData($userId);
        
        return [
            'dashboard_type'    => 'anggota',
            'upcomingAgenda'    => $this->agendaModel->where('tanggal_mulai >=', date('Y-m-d'))->orderBy('tanggal_mulai', 'ASC')->limit(3)->find(),
            'userProfile'       => $userProfile,
            'profileCompletion' => $this->calculateProfileCompletion($userProfile),
            'recentBerita'      => $this->beritaModel->orderBy('created_at', 'DESC')->limit(3)->find(),
            
            // Data sidebar
            'availableAgenda'   => $sidebarData['availableAgenda'],
            'attendanceStats'   => $sidebarData['attendanceStats'],
            'userPoints'        => $sidebarData['userPoints'],
            'progressData'      => $sidebarData['progressData'],
            'recentActivities'  => $sidebarData['recentActivities'],
        ];
    }

    /**
     * Dapatkan data untuk sidebar anggota
     */
    private function getSidebarData($userId)
    {
        try {
            // Agenda yang tersedia untuk diikuti (belum terdaftar)
            $allAgenda = $this->agendaModel->where('tanggal_mulai >=', date('Y-m-d'))
                                          ->orderBy('tanggal_mulai', 'ASC')
                                          ->limit(5)
                                          ->findAll();
            
            $availableAgenda = [];
            foreach ($allAgenda as $agenda) {
                if (!$this->pesertaModel->isUserRegistered($agenda['id'], $userId)) {
                    $agenda['jumlah_peserta'] = $this->pesertaModel->countPeserta($agenda['id']);
                    $availableAgenda[] = $agenda;
                }
            }

            // Statistik kehadiran user
            $totalKehadiran = $this->absensiModel->getTotalKehadiranUser($userId);
            $totalAgendaTerdaftar = $this->pesertaModel->where('id_user', $userId)
                                                     ->where('status_pendaftaran', 'terdaftar')
                                                     ->countAllResults();
            
            $persentaseKehadiran = $totalAgendaTerdaftar > 0 ? 
                round(($totalKehadiran / $totalAgendaTerdaftar) * 100, 1) : 0;

            // Data poin user
            $totalPoin = $this->pointsModel->getTotalPoin($userId);
            $progressData = $this->pointsModel->getProgressKeLevel($totalPoin);
            $riwayatPoin = $this->pointsModel->getRiwayatPoin($userId, 5);

            // Aktivitas terbaru
            $recentActivities = array_merge(
                $this->absensiModel->getRiwayatAbsensiUser($userId, 3),
                $riwayatPoin
            );

            // Sort by date
            usort($recentActivities, function($a, $b) {
                $dateA = $a['waktu_absen'] ?? $a['tanggal_dapat'] ?? '1970-01-01';
                $dateB = $b['waktu_absen'] ?? $b['tanggal_dapat'] ?? '1970-01-01';
                return strtotime($dateB) - strtotime($dateA);
            });

            return [
                'availableAgenda' => array_slice($availableAgenda, 0, 3),
                'attendanceStats' => [
                    'total_kehadiran' => $totalKehadiran,
                    'total_terdaftar' => $totalAgendaTerdaftar,
                    'persentase' => $persentaseKehadiran
                ],
                'userPoints' => $totalPoin,
                'progressData' => $progressData,
                'recentActivities' => array_slice($recentActivities, 0, 5)
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error getting sidebar data: ' . $e->getMessage());
            return [
                'availableAgenda' => [],
                'attendanceStats' => ['total_kehadiran' => 0, 'total_terdaftar' => 0, 'persentase' => 0],
                'userPoints' => 0,
                'progressData' => ['level_sekarang' => ['nama' => 'Anggota Baru'], 'progress_persen' => 0],
                'recentActivities' => []
            ];
        }
    }

    private function calculateProfileCompletion($profile)
    {
        if (!$profile) return 0;
        $fields = ['nama_lengkap', 'email', 'no_hp', 'foto', 'jabatan'];
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($profile[$field])) {
                $completed++;
            }
        }
        return round(($completed / count($fields)) * 100);
    }

    /**
     * Quick join agenda dari sidebar
     */
    public function quickJoinAgenda($id)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
        }

        try {
            // Cek apakah agenda ada
            $agenda = $this->agendaModel->find($id);
            if (!$agenda) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Agenda tidak ditemukan.'
                ]);
            }

            // Daftarkan user ke agenda
            $result = $this->pesertaModel->daftarKeAgenda($id, $userId);
            
            if ($result['success']) {
                // Berikan poin untuk mendaftar agenda
                $this->pointsModel->prosesPoinOtomatis(
                    $userId, 
                    UserPointsModel::AKTIVITAS_DAFTAR_AGENDA, 
                    $id
                );

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berhasil bergabung dengan agenda: ' . $agenda['nama_kegiatan'],
                    'agenda_name' => $agenda['nama_kegiatan']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error quick join agenda: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    public function add_to_calendar($id)
    {
        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            // Handle case where agenda is not found, e.g., redirect with an error message
            return redirect()->back()->with('error', 'Agenda not found.');
        }

        $judul = $agenda['nama_kegiatan'];
        $tanggal = $agenda['tanggal_mulai'];
        $waktu = $agenda['waktu'] ?? ''; // Pastikan waktu tidak undefined
        $deskripsi = $agenda['deskripsi'];

        // Combine date and time for Google Calendar format
        $start_datetime = new \DateTime($tanggal . ' ' . $waktu);
        // For simplicity, assume event lasts 1 hour. Adjust as needed.
        $end_datetime = (clone $start_datetime)->modify('+1 hour');

        $google_calendar_url = 'https://www.google.com/calendar/render?action=TEMPLATE';
        $google_calendar_url .= '&text=' . urlencode($judul);
        $google_calendar_url .= '&dates=' . $start_datetime->format('Ymd\THis\Z') . '/' . $end_datetime->format('Ymd\THis\Z');
        $google_calendar_url .= '&details=' . urlencode($deskripsi);
        $google_calendar_url .= '&sf=true&output=xml';

        return redirect()->to($google_calendar_url);
    }
}
