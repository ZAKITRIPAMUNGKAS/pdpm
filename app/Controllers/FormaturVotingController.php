<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VotingModel;
use App\Models\VotingOptionModel;
use App\Models\VotingVoteModel;
use App\Models\UserModel;

class FormaturVotingController extends BaseController
{
    protected $votingModel;
    protected $votingOptionModel;
    protected $votingVoteModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->votingModel = new VotingModel();
        $this->votingOptionModel = new VotingOptionModel();
        $this->votingVoteModel = new VotingVoteModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
        helper(['form', 'text']);
    }

    /**
     * Display a listing of formatur voting (Super Admin only)
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Voting Formatur',
            'page_title' => 'Daftar Voting Formatur',
            'voting_list' => $this->votingModel->getVotingWithCreator(),
            'stats' => $this->votingModel->getDashboardStats()
        ];

        return view('admin/voting/index', $data);
    }

    /**
     * Show the form for creating a new formatur voting
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Voting Formatur Baru',
            'page_title' => 'Form Buat Voting Formatur',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/voting/create_formatur', $data);
    }

    /**
     * Store a newly created formatur voting
     */
    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'required_selections' => 'required|integer|greater_than_equal_to[1]',
            'min_candidates' => 'required|integer|greater_than_equal_to[1]',
            'show_results_before_end' => 'permit_empty|in_list[0,1]',
            'min_participants' => 'permit_empty|integer|greater_than_equal_to[1]',
            'options' => 'required' // Options will be validated manually below
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

        // Validate minimum candidates
        $options = $this->request->getPost('options');
        $validOptions = array_filter($options, function($option) {
            return !empty(trim($option));
        });

        if (count($validOptions) < 9) {
            return redirect()->back()->withInput()->with('error', 'Minimal harus ada 9 kandidat formatur.');
        }

        $this->db->transStart();

        try {
            // Create voting
            $votingData = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'id_creator' => session()->get('user_id'),
                'allow_multiple_choice' => 1, // Always true for formatur voting
                'required_selections' => $this->request->getPost('required_selections') ?: 9,
                'min_candidates' => $this->request->getPost('min_candidates') ?: 9,
                'show_results_before_end' => $this->request->getPost('show_results_before_end') ? 1 : 0,
                'min_participants' => $this->request->getPost('min_participants') ?: 1,
                'status' => 'draft'
            ];

            $votingId = $this->votingModel->insert($votingData);

            // Create options with photos
            $options = $this->request->getPost('options');
            $photos = $this->request->getPost('photos');
            foreach ($options as $index => $option) {
                if (!empty(trim($option))) {
                    $this->votingOptionModel->insert([
                        'id_voting' => $votingId,
                        'nama_pilihan' => trim($option),
                        'foto' => isset($photos[$index]) ? $photos[$index] : null,
                        'urutan' => $index + 1
                    ]);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return redirect()->to('/admin-voting')->with('success', 'Voting formatur berhasil dibuat.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified formatur voting
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
            'title' => 'Detail Voting Formatur: ' . $voting['judul'],
            'page_title' => 'Detail Voting Formatur',
            'voting' => $voting,
            'stats' => $stats,
            'options' => $options
        ];

        return view('admin/voting/detail_formatur', $data);
    }

    /**
     * Show the form for editing formatur voting
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
            'title' => 'Edit Voting Formatur: ' . $voting['judul'],
            'page_title' => 'Edit Voting Formatur',
            'voting' => $voting,
            'options' => $options,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/voting/edit_formatur', $data);
    }

    /**
     * Update the specified formatur voting
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
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'required_selections' => 'required|integer|greater_than_equal_to[1]',
            'min_candidates' => 'required|integer|greater_than_equal_to[1]',
            'show_results_before_end' => 'permit_empty|in_list[0,1]',
            'min_participants' => 'permit_empty|integer|greater_than_equal_to[1]',
            'options' => 'required' // Options will be validated manually below
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

        // Validate minimum candidates
        $options = $this->request->getPost('options');
        $validOptions = array_filter($options, function($option) {
            return !empty(trim($option));
        });

        if (count($validOptions) < 9) {
            return redirect()->back()->withInput()->with('error', 'Minimal harus ada 9 kandidat formatur.');
        }

        $this->db->transStart();

        try {
            // Update voting
            $votingData = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'allow_multiple_choice' => 1, // Always true for formatur voting
                'required_selections' => $this->request->getPost('required_selections') ?: 9,
                'min_candidates' => $this->request->getPost('min_candidates') ?: 9,
                'show_results_before_end' => $this->request->getPost('show_results_before_end') ? 1 : 0,
                'min_participants' => $this->request->getPost('min_participants') ?: 1
            ];

            $this->votingModel->update($id, $votingData);

            // Delete existing options
            $this->votingOptionModel->where('id_voting', $id)->delete();

            // Create new options with photos
            $options = $this->request->getPost('options');
            $photos = $this->request->getPost('photos');
            foreach ($options as $index => $option) {
                if (!empty(trim($option))) {
                    $this->votingOptionModel->insert([
                        'id_voting' => $id,
                        'nama_pilihan' => trim($option),
                        'foto' => isset($photos[$index]) ? $photos[$index] : null,
                        'urutan' => $index + 1
                    ]);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return redirect()->to('/admin-voting')->with('success', 'Voting formatur berhasil diperbarui.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete formatur voting
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

            return redirect()->to('/admin-voting')->with('success', 'Voting formatur berhasil dihapus.');

        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Change formatur voting status
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

        // When activating, ensure the time window includes now
        if ($newStatus === 'aktif') {
            $now = date('Y-m-d H:i:s');
            $tanggalMulai = $voting['tanggal_mulai'];
            $tanggalSelesai = $voting['tanggal_selesai'];

            // If start is in the future, pull it to now
            if ($now < $tanggalMulai) {
                $tanggalMulai = $now;
            }
            // If end is in the past or <= start, push it forward 2 hours
            if ($now > $tanggalSelesai || strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
                $tanggalSelesai = date('Y-m-d H:i:s', strtotime('+2 hours'));
            }

            $this->votingModel->update($id, [
                'status' => 'aktif',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ]);
        } else {
            $this->votingModel->update($id, ['status' => $newStatus]);
        }

        $statusText = [
            'draft' => 'Draft',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        return redirect()->to('/admin-voting')->with('success', 'Status voting formatur berhasil diubah menjadi ' . $statusText[$newStatus] . '.');
    }

    /**
     * Get formatur voting results (AJAX)
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
     * Export formatur voting results
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
        $csvContent = "Hasil Voting Formatur: " . $voting['judul'] . "\n";
        $csvContent .= "Tanggal: " . date('d/m/Y H:i') . "\n\n";
        
        $csvContent .= "Statistik:\n";
        $csvContent .= "Total Suara: " . $stats['total_votes'] . "\n";
        $csvContent .= "Total Pemilih: " . $stats['unique_voters'] . "\n";
        $csvContent .= "Formatur yang Harus Dipilih: " . $voting['required_selections'] . "\n\n";
        
        $csvContent .= "Hasil per Kandidat Formatur:\n";
        foreach ($stats['options'] as $option) {
            $csvContent .= $option['nama_pilihan'] . ": " . $option['vote_count'] . " suara\n";
        }
        
        $csvContent .= "\nDetail Suara:\n";
        $csvContent .= "Nama Pemilih,Formatur Terpilih,Waktu\n";
        foreach ($results as $result) {
            $csvContent .= $result['nama_lengkap'] . "," . $result['nama_pilihan'] . "," . $result['created_at'] . "\n";
        }

        $filename = 'hasil_voting_formatur_' . $voting['id'] . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        return $this->response->download($filename, $csvContent);
    }
}
