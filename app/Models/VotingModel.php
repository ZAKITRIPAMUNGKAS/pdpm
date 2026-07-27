<?php

namespace App\Models;

use CodeIgniter\Model;

class VotingModel extends Model
{
    protected $table            = 'voting';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'deskripsi',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'id_creator',
        'allow_multiple_choice',
        'required_selections',
        'min_candidates',
        'show_results_before_end',
        'min_participants',
        'total_voters'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'status' => 'required|in_list[draft,aktif,selesai,dibatalkan]',
        'id_creator' => 'required|integer',
        'allow_multiple_choice' => 'permit_empty|in_list[0,1]',
        'required_selections' => 'permit_empty|integer|greater_than_equal_to[1]',
        'min_candidates' => 'permit_empty|integer|greater_than_equal_to[1]',
        'show_results_before_end' => 'permit_empty|in_list[0,1]',
        'min_participants' => 'permit_empty|integer|greater_than_equal_to[1]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get voting with creator details
     */
    public function getVotingWithCreator($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('voting.*, users.nama_lengkap as creator_name');
        $builder->join('users', 'users.id = voting.id_creator', 'left');
        
        if ($id) {
            $builder->where('voting.id', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('voting.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    /**
     * Get active voting for public
     */
    public function getActiveVoting()
    {
        $builder = $this->db->table($this->table);
        $builder->select('voting.*, users.nama_lengkap as creator_name');
        $builder->join('users', 'users.id = voting.id_creator', 'left');
        // Show all items explicitly marked as active, regardless of time window
        $builder->where('voting.status', 'aktif');
        $builder->orderBy('voting.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get voting statistics
     */
    public function getVotingStats($id)
    {
        $voting = $this->find($id);
        if (!$voting) {
            return null;
        }

        // Get total votes
        $totalVotes = $this->db->table('voting_votes')
            ->where('id_voting', $id)
            ->countAllResults();

        // Get unique voters
        $uniqueVoters = $this->db->table('voting_votes')
            ->select('COUNT(DISTINCT id_user) as total')
            ->where('id_voting', $id)
            ->get()
            ->getRowArray();

        // Get options with vote counts
        $options = $this->db->table('voting_options')
            ->select('voting_options.*, COUNT(voting_votes.id) as vote_count')
            ->join('voting_votes', 'voting_votes.id_voting_option = voting_options.id', 'left')
            ->where('voting_options.id_voting', $id)
            ->groupBy('voting_options.id')
            ->orderBy('voting_options.urutan', 'ASC')
            ->get()
            ->getResultArray();

        return [
            'voting' => $voting,
            'total_votes' => $totalVotes,
            'unique_voters' => $uniqueVoters['total'] ?? 0,
            'options' => $options
        ];
    }

    /**
     * Check if user has voted
     */
    public function hasUserVoted($votingId, $userId)
    {
        return $this->db->table('voting_votes')
            ->where('id_voting', $votingId)
            ->where('id_user', $userId)
            ->countAllResults() > 0;
    }

    /**
     * Get user's votes for a voting
     */
    public function getUserVotes($votingId, $userId)
    {
        return $this->db->table('voting_votes')
            ->select('voting_votes.*, voting_options.nama_pilihan')
            ->join('voting_options', 'voting_options.id = voting_votes.id_voting_option')
            ->where('voting_votes.id_voting', $votingId)
            ->where('voting_votes.id_user', $userId)
            ->get()
            ->getResultArray();
    }

    /**
     * Update voting status based on dates
     */
    public function updateVotingStatus()
    {
        // Set voting to active if start date reached
        $this->where('status', 'draft')
            ->where('tanggal_mulai <=', date('Y-m-d H:i:s'))
            ->set('status', 'aktif')
            ->update();

        // Set voting to finished if end date reached
        $this->where('status', 'aktif')
            ->where('tanggal_selesai <=', date('Y-m-d H:i:s'))
            ->set('status', 'selesai')
            ->update();
    }

    /**
     * Get voting dashboard statistics
     */
    public function getDashboardStats()
    {
        $stats = [
            'total_voting' => $this->countAllResults(),
            'active_voting' => $this->where('status', 'aktif')->countAllResults(),
            'finished_voting' => $this->where('status', 'selesai')->countAllResults(),
            'draft_voting' => $this->where('status', 'draft')->countAllResults(),
        ];

        // Get recent voting
        $stats['recent_voting'] = $this->getVotingWithCreator();
        $stats['recent_voting'] = array_slice($stats['recent_voting'], 0, 5);

        return $stats;
    }
}
