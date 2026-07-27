<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VotingModel;
use App\Models\VotingOptionModel;
use App\Models\VotingVoteModel;

class VotingParticipantController extends BaseController
{
    protected $votingModel;
    protected $votingOptionModel;
    protected $votingVoteModel;
    protected $db;

    public function __construct()
    {
        $this->votingModel = new VotingModel();
        $this->votingOptionModel = new VotingOptionModel();
        $this->votingVoteModel = new VotingVoteModel();
        $this->db = \Config\Database::connect();
        helper(['form', 'text']);
    }

    /**
     * Display active voting for participants
     */
    public function index()
    {
        $data = [
            'title' => 'Voting Aktif',
            'page_title' => 'Daftar Voting',
            'voting_list' => $this->votingModel->getActiveVoting()
        ];

        return view('voting/index', $data);
    }

    /**
     * Show voting detail and voting form
     */
    public function show($id)
    {
        $voting = $this->votingModel->getVotingWithCreator($id);
        if (!$voting) {
            return redirect()->to('/voting')->with('error', 'Voting tidak ditemukan.');
        }

        // Check if voting is active
        if ($voting['status'] !== 'aktif') {
            return redirect()->to('/voting')->with('error', 'Voting tidak sedang berlangsung.');
        }

        // Check if voting is within time range
        $now = date('Y-m-d H:i:s');
        if ($now < $voting['tanggal_mulai'] || $now > $voting['tanggal_selesai']) {
            return redirect()->to('/voting')->with('error', 'Voting belum dimulai atau sudah berakhir.');
        }

        $userId = session()->get('user_id');
        $options = $this->votingOptionModel->getOptionsByVoting($id);
        $hasVoted = $this->votingModel->hasUserVoted($id, $userId);
        $userVotes = $hasVoted ? $this->votingModel->getUserVotes($id, $userId) : [];

        // Get results if allowed
        $stats = null;
        if ($voting['show_results_before_end'] || $voting['status'] === 'selesai') {
            $stats = $this->votingModel->getVotingStats($id);
        }

        $data = [
            'title' => 'Voting: ' . $voting['judul'],
            'page_title' => 'Voting',
            'voting' => $voting,
            'options' => $options,
            'hasVoted' => $hasVoted,
            'userVotes' => $userVotes,
            'stats' => $stats,
            'canVote' => $this->votingVoteModel->canUserVote($id, $userId, $voting['allow_multiple_choice'])
        ];

        // Use formatur-specific view if this is a formatur voting
        $viewName = isset($voting['required_selections']) && $voting['required_selections'] > 0 ? 'voting/detail_formatur' : 'voting/detail';
        return view($viewName, $data);
    }

    /**
     * Submit vote
     */
    public function vote($id)
    {
        $voting = $this->votingModel->find($id);
        if (!$voting) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voting tidak ditemukan.'
            ]);
        }

        // Check if voting is active
        if ($voting['status'] !== 'aktif') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voting tidak sedang berlangsung.'
            ]);
        }

        // Check if voting is within time range
        $now = date('Y-m-d H:i:s');
        if ($now < $voting['tanggal_mulai'] || $now > $voting['tanggal_selesai']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Voting belum dimulai atau sudah berakhir.'
            ]);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $selectedOptions = $this->request->getPost('options');
        if (empty($selectedOptions)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pilih minimal satu pilihan.'
            ]);
        }

        // For formatur voting, validate exactly 9 selections
        if (isset($voting['required_selections']) && $voting['required_selections'] > 0) {
            if (count($selectedOptions) != $voting['required_selections']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda harus memilih tepat ' . $voting['required_selections'] . ' formatur.'
                ]);
            }
        }

        // Validate options
        $validOptions = $this->votingOptionModel->getOptionsByVoting($id);
        $validOptionIds = array_column($validOptions, 'id');
        
        foreach ($selectedOptions as $optionId) {
            if (!in_array($optionId, $validOptionIds)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Pilihan tidak valid.'
                ]);
            }
        }

        // Check if user can vote
        if (!$this->votingVoteModel->canUserVote($id, $userId, $voting['allow_multiple_choice'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda sudah memberikan suara untuk voting ini.'
            ]);
        }

        $this->db->transStart();

        try {
            // If not multiple choice, remove existing votes first
            if (!$voting['allow_multiple_choice']) {
                $this->votingVoteModel->where('id_voting', $id)
                    ->where('id_user', $userId)
                    ->delete();
            }

            // Insert new votes
            foreach ($selectedOptions as $optionId) {
                $this->votingVoteModel->insert([
                    'id_voting' => $id,
                    'id_voting_option' => $optionId,
                    'id_user' => $userId
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Suara berhasil disimpan.'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
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

        // Check if results can be shown
        if (!$voting['show_results_before_end'] && $voting['status'] !== 'selesai') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Hasil voting belum dapat dilihat.'
            ]);
        }

        $stats = $this->votingModel->getVotingStats($id);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get user's voting history
     */
    public function history()
    {
        $userId = session()->get('user_id');
        $history = $this->votingVoteModel->getUserVotingHistory($userId);

        $data = [
            'title' => 'Riwayat Voting',
            'page_title' => 'Riwayat Voting Saya',
            'history' => $history
        ];

        return view('voting/history', $data);
    }
}
