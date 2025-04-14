<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0"><i class="fas fa-wallet me-2"></i> Riwayat Top-Up</h4>
        </div>
        <div class="card-body">
            <!-- Alert Notifikasi -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Tombol dan Form Pencarian -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex">
                    <a href="<?= base_url('topup/create') ?>" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Tambah Top-Up
                    </a>
                    <a href="<?= base_url('topup/exportExcel') ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor ke Excel
                    </a>
                </div>
                <form action="<?= base_url('topup') ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Cari Top-Up..." class="form-control" value="<?= isset($keyword) ? $keyword : '' ?>">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Tampilkan pesan jika tidak ada data -->
            <?php if (empty($topups)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada riwayat top-up yang ditemukan.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="fas fa-id-badge"></i> No Santri</th>
                                <th><i class="fas fa-user"></i> Nama</th>
                                <th><i class="fas fa-money-bill-wave"></i> Nominal</th>
                                <th><i class="fas fa-credit-card"></i> Metode Pembayaran</th>
                                <th><i class="fas fa-user-shield"></i> Admin</th>
                                <th><i class="fas fa-calendar-alt"></i> Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topups as $topup): ?>
                                <tr>
                                    <td class="text-nowrap"><?= esc($topup['no_santri']) ?></td>
                                    <td class="text-nowrap"><?= esc($topup['nama']) ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($topup['nominal'], 2, ',', '.') ?></td>
                                    <td>
                                        <?php if ($topup['metode_pembayaran'] === 'transfer'): ?>
                                            <span class="badge bg-info"><i class="fas fa-university"></i> Transfer</span>
                                        <?php elseif ($topup['metode_pembayaran'] === 'cash'): ?>
                                            <span class="badge bg-warning"><i class="fas fa-money-bill-wave"></i> Cash</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= esc($topup['metode_pembayaran']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap"><?= esc($topup['admin']) ?></td>
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($topup['tanggal'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
