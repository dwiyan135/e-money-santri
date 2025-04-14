<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="mb-4 text-primary"><i class="fas fa-edit"></i> Edit Transaksi</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow-sm">
        <form action="<?= base_url('transaksi/update/' . $transaksi['id_transaksi']) ?>" method="post">
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user-graduate"></i> No Santri</label>
                <input type="text" class="form-control" value="<?= esc($transaksi['no_santri']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-id-badge"></i> Nama Santri</label>
                <input type="text" class="form-control" value="<?= esc($transaksi['nama_santri']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-money-bill-wave"></i> Total Harga</label>
                <input type="number" name="total_harga" class="form-control" value="<?= esc($transaksi['total_harga']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-credit-card"></i> Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-select" required>
                    <option value="tunai" <?= $transaksi['metode_pembayaran'] == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                    <option value="e-money" <?= $transaksi['metode_pembayaran'] == 'e-money' ? 'selected' : '' ?>>E-Money (QR Code)</option>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
