<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AgendaModel;

class CleanupExpiredAgenda extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Housekeeping';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'agenda:cleanup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Menghapus agenda yang sudah melewati tanggal selesai';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'agenda:cleanup [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--dry-run' => 'Hanya menampilkan agenda yang akan dihapus tanpa menghapusnya',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $agendaModel = new AgendaModel();
        $isDryRun = CLI::getOption('dry-run') !== null;

        // Ambil agenda yang sudah lewat
        $expiredAgenda = $agendaModel->where('tanggal_selesai <', date('Y-m-d H:i:s'))
                                    ->orWhere('tanggal_mulai <', date('Y-m-d H:i:s'))
                                    ->where('tanggal_selesai IS NULL')
                                    ->findAll();

        if (empty($expiredAgenda)) {
            CLI::write('Tidak ada agenda yang perlu dibersihkan.', 'green');
            return;
        }

        $count = count($expiredAgenda);
        
        if ($isDryRun) {
            CLI::write("Mode dry-run: {$count} agenda akan dihapus:", 'yellow');
            foreach ($expiredAgenda as $agenda) {
                CLI::write("- {$agenda['nama_kegiatan']} ({$agenda['tanggal_mulai']})", 'white');
            }
            return;
        }

        // Hapus agenda yang sudah lewat
        $deletedCount = 0;
        foreach ($expiredAgenda as $agenda) {
            if ($agendaModel->delete($agenda['id'])) {
                $deletedCount++;
                CLI::write("Dihapus: {$agenda['nama_kegiatan']}", 'red');
            }
        }

        CLI::write("Berhasil menghapus {$deletedCount} agenda yang sudah lewat.", 'green');
    }
}
