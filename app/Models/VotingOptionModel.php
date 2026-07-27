<?php

namespace App\Models;

use CodeIgniter\Model;

class VotingOptionModel extends Model
{
    protected $table            = 'voting_options';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_voting',
        'nama_pilihan',
        'deskripsi',
        'foto',
        'urutan',
        'total_votes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_voting' => 'required|integer',
        'nama_pilihan' => 'required|min_length[1]|max_length[255]',
        'urutan' => 'permit_empty|integer|greater_than_equal_to[1]',
        'total_votes' => 'permit_empty|integer|greater_than_equal_to[0]'
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
     * Get options for a specific voting
     */
    public function getOptionsByVoting($votingId)
    {
        return $this->where('id_voting', $votingId)
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }

    /**
     * Get options with vote statistics
     */
    public function getOptionsWithStats($votingId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('voting_options.*, COUNT(voting_votes.id) as vote_count');
        $builder->join('voting_votes', 'voting_votes.id_voting_option = voting_options.id', 'left');
        $builder->where('voting_options.id_voting', $votingId);
        $builder->groupBy('voting_options.id');
        $builder->orderBy('voting_options.urutan', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Update vote count for an option
     */
    public function updateVoteCount($optionId)
    {
        $voteCount = $this->db->table('voting_votes')
            ->where('id_voting_option', $optionId)
            ->countAllResults();

        $this->update($optionId, ['total_votes' => $voteCount]);
    }

    /**
     * Reorder options
     */
    public function reorderOptions($votingId, $optionIds)
    {
        foreach ($optionIds as $index => $optionId) {
            $this->update($optionId, ['urutan' => $index + 1]);
        }
    }
}
