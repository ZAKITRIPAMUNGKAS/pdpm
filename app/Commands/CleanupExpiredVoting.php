<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\VotingModel;

class CleanupExpiredVoting extends BaseCommand
{
    protected $group       = 'voting';
    protected $name        = 'voting:cleanup';
    protected $description = 'Update status of expired voting to finished';

    public function run(array $params)
    {
        $votingModel = new VotingModel();
        
        // Update voting status based on dates
        $votingModel->updateVotingStatus();
        
        CLI::write('Voting status cleanup completed successfully.', 'green');
    }
}
