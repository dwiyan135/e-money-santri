<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0">
                <i class="fas fa-history me-2"></i> Riwayat Transaksi
            </h4>
            <div>
                <a href="<?= base_url('transaksi/tambah') ?>" class="btn btn-light me-2 shadow-sm">
                    <i class="fas fa-plus-circle"></i> Tambah Transaksi
                </a>
                <a href="<?= base_url('transaksi/exportExcel') ?>" class="btn btn-success shadow-sm">
                    <i class="fas fa-file-excel"></i> Export ke Excel
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Alert Notifikasi -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form Pencarian -->
            <form action="<?= base_url('transaksi') ?>" method="get" class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                    <input type="text" name="keyword" class="form-control shadow-sm" placeholder="Cari transaksi..." value="<?= isset($keyword) ? esc($keyword) : '' ?>">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>

            <!-- Tabel Transaksi -->
            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-id-card"></i> No Santri</th>
                            <th><i class="fas fa-user"></i> Nama Santri</th>
                            <th><i class="fas fa-money-bill-wave"></i> Total Harga</th>
                            <th><i class="fas fa-credit-card"></i> Metode Pembayaran</th>
                            <th><i class="fas fa-calendar-alt"></i> Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi) && is_array($transaksi)): ?>
                            <?php foreach ($transaksi as $row) : ?>
                                <tr>
                                    <td><?= esc($row['id_transaksi']) ?></td>
                                    <td><?= esc($row['no_santri']) ?></td>
                                    <td><?= esc($row['nama_santri']) ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-money-bill-wave"></i> Rp <?= number_format($row['total_harga'], 2, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['metode_pembayaran'] === 'e-money'): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-qrcode"></i> <?= ucfirst(esc($row['metode_pembayaran'])) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">
                                                <i class="fas fa-money-bill-wave"></i> <?= ucfirst(esc($row['metode_pembayaran'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada transaksi ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById('qr-video');
        const codeReader = new ZXing.BrowserQRCodeReader();

        function startScan() {
            codeReader.getVideoInputDevices()
                .then(videoInputDevices => {
                    if (videoInputDevices.length > 0) {
                        let selectedDeviceId = videoInputDevices[0].deviceId;
                        videoInputDevices.forEach(device => {
                            if (device.label.toLowerCase().includes('back')) {
                                selectedDeviceId = device.deviceId;
                            }
                        });

                        codeReader.decodeFromVideoDevice(selectedDeviceId, 'qr-video', (result, err) => {
                            if (result) {
                                let noSantri = result.text.replace("ID Santri:", "").trim();
                                window.location.href = "/transaksi/tambah?no_santri=" + noSantri;
                            }
                            if (err && !(err instanceof ZXing.NotFoundException)) {
                                console.error(err);
                            }
                        });
                    }
                })
                .catch(err => console.error("Gagal mengakses kamera: ", err));
        }

        startScan();
    });
</script>

<?= $this->endSection() ?>