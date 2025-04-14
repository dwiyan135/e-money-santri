<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg border-0 p-4 text-center" style="border-radius: 15px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary"><i class="fas fa-qrcode"></i> QR Code Santri</h2>
                <p class="text-muted">Informasi lengkap santri beserta QR Code</p>
            </div>

            <div class="text-start">
                <p><strong>ID Santri:</strong> <span class="badge bg-primary"><?= esc($santri['id_santri']) ?></span></p>
                <p><strong>Nama:</strong> <?= esc($santri['nama']) ?></p>
                <p><strong>Alamat:</strong> <?= esc($santri['alamat']) ?></p>
                <p><strong>Tempat Lahir:</strong> <?= esc($santri['tempat_lahir']) ?></p>
                <p><strong>Tanggal Lahir:</strong> <?= esc($santri['tanggal_lahir']) ?></p>
                <p><strong>No Telepon:</strong> <?= esc($santri['no_telp']) ?></p>
                <p><strong>Kelas:</strong> <?= esc($santri['kelas']) ?></p>
                <p><strong>Unit Pendidikan:</strong> <?= esc($santri['unit_pendidikan']) ?></p>
            </div>

            <div class="text-center mt-4">
                <h4 class="fw-bold text-success"><i class="fas fa-qrcode"></i> QR Code:</h4>
                <div class="d-flex justify-content-center">
                    <img src="<?= esc($qr_image) ?>" alt="QR Code" class="img-fluid border rounded p-2 shadow" style="max-width: 200px;">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <a href="<?= base_url('santri') ?>" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>