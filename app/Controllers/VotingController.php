<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VotingModel;
use App\Models\VotingOptionModel;
use App\Models\VotingVoteModel;
use App\Models\UserModel;

class VotingController extends BaseController
{
    protected $votingModel;
    protected $votingOptionModel;
    protected $votingVoteModel;
    protected $userModel;

    public function __construct()
    {
        $this->votingModel = new VotingModel();
        $this->votingOptionModel = new VotingOptionModel();
        $this->votingVoteModel = new VotingVoteModel();
        $this->userModel = new UserModel();
        helper(['form', 'text']);
    }

    /**
     * Display a listing of voting (Super Admin only)
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Voting',
            'page_title' => 'Daftar Voting',
            'voting_list' => $this->votingModel->getVotingWithCreator(),
            'stats' => $this->votingModel->getDashboardStats()
        ];

        return view('admin/voting/index', $data);
    }

    /**
     * Show the form for creating a new voting
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Voting Baru',
            'page_title' => 'Form Buat Voting',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/voting/create', $data);
    }

    /**
     * Store a newly created voting
     */
    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty',
            'tipe_voting' => 'required|in_list[pemilihan_ketua,musyawarah,keputusan_organisasi,lainnya]',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'allow_multiple_choice' => 'permit_empty|in_list[0,1]',
            'show_results_before_end' => 'permit_empty|in_list[0,1]',
            'min_participants' => 'permit_empty|integer|greater_than_equal_to[1]',
            'options' => 'required|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate dates
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai harus setelah tanggal mulai.');
        }

        $this->db->transStart();

        try {
            // Create voting
            $votingData = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tipe_voting' => $this->request->getPost('tipe_voting'),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'id_creator' => session()->get('user_id'),
                'allow_multiple_choice' => $this->request->getPost('allow_multiple_choice') ? 1 : 0,
                'show_results_before_end' => $this->request->getPost('show_results_before_end') ? 1 : 0,
                'min_participants' => $this->request->getPost('min_participants') ?: 1,
                'status' => 'draft'
            ];

            $votingId = $this->votingModel->insert($votingData);

            // Create options
            $options = $this->request->getPost('options');
            foreach ($options as $index => $option) {
                if (!empty(trim($option))) {
                    $this->votingOptionModel->insert([
                        'id_voting' => $votingId,
                        'nama_pilihan' => trim($option),
                        'urutan' => $index + 1
                    ]);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return redirect()->to('/admin-voting')->with('success', 'Voting berhasil dibuat.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified voting
     */
    public function show($id)
    {
        $voting = $this->votingModel->getVotingWithCreator($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        $stats = $this->votingModel->getVotingStats($id);
        $options = $this->votingOptionModel->getOptionsWithStats($id);

        $data = [
            'title' => 'Detail Voting: ' . $voting['judul'],
            'page_title' => 'Detail Voting',
            'voting' => $voting,
            'stats' => $stats,
            'options' => $options
        ];

        return view('admin/voting/detail', $data);
    }

    /**
     * Show the form for editing voting
     */
    public function edit($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        // Can't edit if voting is active or finished
        if (in_array($voting['status'], ['aktif', 'selesai'])) {
            return redirect()->to('/admin-voting')->with('error', 'Voting yang sudah aktif atau selesai tidak dapat diedit.');
        }

        $options = $this->votingOptionModel->getOptionsByVoting($id);

        $data = [
            'title' => 'Edit Voting: ' . $voting['judul'],
            'page_title' => 'Edit Voting',
            'voting' => $voting,
            'options' => $options,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/voting/edit', $data);
    }

    /**
     * Update the specified voting
     */
    public function update($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        // Can't edit if voting is active or finished
        if (in_array($voting['status'], ['aktif', 'selesai'])) {
            return redirect()->to('/admin-voting')->with('error', 'Voting yang sudah aktif atau selesai tidak dapat diedit.');
        }

        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty',
            'tipe_voting' => 'required|in_list[pemilihan_ketua,musyawarah,keputusan_organisasi,lainnya]',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'allow_multiple_choice' => 'permit_empty|in_list[0,1]',
            'show_results_before_end' => 'permit_empty|in_list[0,1]',
            'min_participants' => 'permit_empty|integer|greater_than_equal_to[1]',
            'options' => 'required|min_length[2]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate dates
        $tanggalMulai = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');
        
        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai harus setelah tanggal mulai.');
        }

        $this->db->transStart();

        try {
            // Update voting
            $votingData = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tipe_voting' => $this->request->getPost('tipe_voting'),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'allow_multiple_choice' => $this->request->getPost('allow_multiple_choice') ? 1 : 0,
                'show_results_before_end' => $this->request->getPost('show_results_before_end') ? 1 : 0,
                'min_participants' => $this->request->getPost('min_participants') ?: 1
            ];

            $this->votingModel->update($id, $votingData);

            // Delete existing options
            $this->votingOptionModel->where('id_voting', $id)->delete();

            // Create new options
            $options = $this->request->getPost('options');
            foreach ($options as $index => $option) {
                if (!empty(trim($option))) {
                    $this->votingOptionModel->insert([
                        'id_voting' => $id,
                        'nama_pilihan' => trim($option),
                        'urutan' => $index + 1
                    ]);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return redirect()->to('/admin-voting')->with('success', 'Voting berhasil diperbarui.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete voting
     */
    public function delete($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        // Can't delete if voting is active or has votes
        if ($voting['status'] === 'aktif') {
            return redirect()->to('/admin-voting')->with('error', 'Voting yang sedang aktif tidak dapat dihapus.');
        }

        $this->db->transStart();

        try {
            // Delete votes
            $this->votingVoteModel->where('id_voting', $id)->delete();
            
            // Delete options
            $this->votingOptionModel->where('id_voting', $id)->delete();
            
            // Delete voting
            $this->votingModel->delete($id);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return redirect()->to('/admin-voting')->with('success', 'Voting berhasil dihapus.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->to('/admin-voting')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Change voting status
     */
    public function changeStatus($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $validStatuses = ['draft', 'aktif', 'selesai', 'dibatalkan'];

        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->to('/admin-voting')->with('error', 'Status tidak valid.');
        }

        // Validate status transitions
        if ($voting['status'] === 'selesai' && $newStatus !== 'selesai') {
            return redirect()->to('/admin-voting')->with('error', 'Voting yang sudah selesai tidak dapat diubah statusnya.');
        }

        $this->votingModel->update($id, ['status' => $newStatus]);

        $statusText = [
            'draft' => 'Draft',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        return redirect()->to('/admin-voting')->with('success', 'Status voting berhasil diubah menjadi ' . $statusText[$newStatus] . '.');
    }

    /**
     * Get voting results (AJAX)
     */
    public function getResults($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voting tidak ditemukan.'
            ]);
        }

        $stats = $this->votingModel->getVotingStats($id);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Export voting results
     */
    public function exportResults($id)
    {
        $voting = $this->votingModel->getVotingWithCreator($id);
        if (!$voting) {
            return redirect()->to('/admin-voting')->with('error', 'Voting tidak ditemukan.');
        }

        $stats = $this->votingModel->getVotingStats($id);
        $results = $this->votingVoteModel->getVotingResults($id);

        // Create CSV content
        $csvContent = "Hasil Voting: " . $voting['judul'] . "\n";
        $csvContent .= "Tanggal: " . date('d/m/Y H:i') . "\n\n";
        
        $csvContent .= "Statistik:\n";
        $csvContent .= "Total Suara: " . $stats['total_votes'] . "\n";
        $csvContent .= "Total Pemilih: " . $stats['unique_voters'] . "\n\n";
        
        $csvContent .= "Hasil per Pilihan:\n";
        foreach ($stats['options'] as $option) {
            $csvContent .= $option['nama_pilihan'] . ": " . $option['vote_count'] . " suara\n";
        }
        
        $csvContent .= "\nDetail Suara:\n";
        $csvContent .= "Nama Pemilih,Pilihan,Waktu\n";
        foreach ($results as $result) {
            $csvContent .= $result['nama_lengkap'] . "," . $result['nama_pilihan'] . "," . $result['created_at'] . "\n";
        }

        $filename = 'hasil_voting_' . $voting['id'] . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        return $this->response->download($filename, $csvContent);
    }
}
