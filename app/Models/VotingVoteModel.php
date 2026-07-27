<?php

namespace App\Models;

use CodeIgniter\Model;

class VotingVoteModel extends Model
{
    protected $table            = 'voting_votes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_voting',
        'id_voting_option',
        'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    // Table does not have updated_at; avoid writing a non-existent column
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_voting' => 'required|integer',
        'id_voting_option' => 'required|integer',
        'id_user' => 'required|integer'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ['updateVoteCounts'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['updateVoteCounts'];

    /**
     * Update vote counts after insert/delete
     */
    protected function updateVoteCounts(array $data)
    {
        if (isset($data['id_voting_option'])) {
            $optionModel = new VotingOptionModel();
            $optionModel->updateVoteCount($data['id_voting_option']);
        }
        
        if (isset($data['id_voting'])) {
            $votingModel = new VotingModel();
            $votingModel->update($data['id_voting'], [
                'total_voters' => $this->getUniqueVotersCount($data['id_voting'])
            ]);
        }
    }

    /**
     * Get unique voters count for a voting
     */
    public function getUniqueVotersCount($votingId)
    {
        return $this->db->table($this->table)
            ->select('COUNT(DISTINCT id_user) as total')
            ->where('id_voting', $votingId)
            ->get()
            ->getRowArray()['total'] ?? 0;
    }

    /**
     * Check if user can vote (hasn't voted yet or multiple choice allowed)
     */
    public function canUserVote($votingId, $userId, $allowMultiple = false)
    {
        $hasVoted = $this->where('id_voting', $votingId)
            ->where('id_user', $userId)
            ->countAllResults() > 0;

        return !$hasVoted || $allowMultiple;
    }

    /**
     * Get voting results with user details
     */
    public function getVotingResults($votingId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('voting_votes.*, users.nama_lengkap, voting_options.nama_pilihan');
        $builder->join('users', 'users.id = voting_votes.id_user');
        $builder->join('voting_options', 'voting_options.id = voting_votes.id_voting_option');
        $builder->where('voting_votes.id_voting', $votingId);
        $builder->orderBy('voting_votes.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get user's voting history
     */
    public function getUserVotingHistory($userId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('voting_votes.*, voting.judul, voting_options.nama_pilihan');
        $builder->join('voting', 'voting.id = voting_votes.id_voting');
        $builder->join('voting_options', 'voting_options.id = voting_votes.id_voting_option');
        $builder->where('voting_votes.id_user', $userId);
        $builder->orderBy('voting_votes.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}
