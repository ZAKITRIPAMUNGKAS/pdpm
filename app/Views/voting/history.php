<?= $this->extend('layout/member') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('voting') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Voting
        </a>
    </div>

    <!-- Voting History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Voting Saya</h6>
        </div>
        <div class="card-body">
            <?php if (empty($history)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-ui-checks fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Anda belum pernah mengikuti voting.</p>
                    <a href="<?= base_url('voting') ?>" class="btn btn-primary">Lihat Voting Aktif</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul Voting</th>
                                <th>Pilihan Saya</th>
                                <th>Tanggal Voting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $currentVoting = null;
                            $votingVotes = [];
                            
                            // Group votes by voting
                            foreach ($history as $vote) {
                                if ($currentVoting !== $vote['judul']) {
                                    if ($currentVoting !== null) {
                                        // Display previous voting
                                        $firstVote = $votingVotes[0];
                                        $choices = array_column($votingVotes, 'nama_pilihan');
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($currentVoting) ?></strong>
                                            </td>
                                            <td>
                                                <?php if (count($choices) > 1): ?>
                                                    <ul class="mb-0">
                                                        <?php foreach ($choices as $choice): ?>
                                                            <li><?= esc($choice) ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <?= esc($choices[0]) ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y H:i', strtotime($firstVote['created_at'])) ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $currentVoting = $vote['judul'];
                                    $votingVotes = [];
                                }
                                $votingVotes[] = $vote;
                            }
                            
                            // Display last voting
                            if ($currentVoting !== null) {
                                $firstVote = $votingVotes[0];
                                $choices = array_column($votingVotes, 'nama_pilihan');
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($currentVoting) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (count($choices) > 1): ?>
                                            <ul class="mb-0">
                                                <?php foreach ($choices as $choice): ?>
                                                    <li><?= esc($choice) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <?= esc($choices[0]) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($firstVote['created_at'])) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
