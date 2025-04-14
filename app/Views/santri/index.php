<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0"><i class="fas fa-user-graduate me-2"></i> Daftar Santri</h4>
        </div>

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
        <div class="card-body">
            <!-- Tombol Tambah & Ekspor -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="<?= base_url('santri/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Santri
                    </a>
                    <a href="<?= base_url('santri/exportExcel') ?>" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor ke Excel
                    </a>
                </div>
                <!-- Form Pencarian -->
                <form action="<?= base_url('santri') ?>" method="get" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari Santri..." value="<?= isset($keyword) ? esc($keyword) : '' ?>">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Santri -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No Santri</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                            <th>Saldo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($santri as $s): ?>
                            <tr>
                                <td><?= esc($s['no_santri']) ?></td>
                                <td><?= esc($s['nama']) ?></td>
                                <td><?= esc($s['alamat']) ?></td>
                                <td><?= esc($s['kelas']) ?></td>
                                <td><span class="badge bg-success">Rp <?= number_format($s['saldo'], 2, ',', '.') ?></span></td>
                                <td class="text-nowrap">
                                    <!-- Tombol Detail -->
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $s['id_santri'] ?>">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>

                                    <!-- Tombol Perbarui PIN -->
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatePinModal<?= $s['id_santri'] ?>">
                                        <i class="fas fa-key"></i> Ubah PIN
                                    </button>

                                    <!-- Tombol Edit -->
                                    <a href="<?= base_url('santri/edit/' . $s['id_santri']) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('santri/delete/' . $s['id_santri']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus santri ini?')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Detail Santri -->
                            <div class="modal fade" id="detailModal<?= $s['id_santri'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="fas fa-user"></i> Detail Santri - <?= esc($s['nama']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h4 class="fw-bold"><?= esc($s['nama']) ?></h4>
                                            <p>No Santri: <strong><?= esc($s['no_santri']) ?></strong></p>
                                            <p>Kelas: <?= esc($s['kelas']) ?></p>
                                            <p>Saldo: Rp <?= number_format($s['saldo'], 2, ',', '.') ?></p>

                                            <!-- Tampilkan QR Code -->
                                            <div class="mt-3">
                                                <img src="<?= base_url('santri/showQrCode/' . $s['id_santri']) ?>" alt="QR Code" class="img-fluid border rounded" width="150">
                                                <p class="text-muted">QR Code</p>
                                            </div>

                                            <!-- Form Verifikasi PIN sebelum Regenerate QR -->
                                            <form action="<?= base_url('santri/regenerateQr/' . $s['id_santri']) ?>" method="post">
                                                <div class="mb-3 mt-3">
                                                    <label class="form-label">Masukkan PIN untuk Regenerate QR</label>
                                                    <input type="password" name="pin" class="form-control text-center" minlength="6" required>
                                                </div>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-sync-alt"></i> Regenerate QR
                                                </button>
                                            </form>

                                            <!-- Tombol Download QR Code -->
                                            <a href="<?= base_url('santri/downloadQrCode/' . $s['id_santri']) ?>" class="btn btn-success mt-2">
                                                <i class="fas fa-download"></i> Download QR
                                            </a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Perbarui PIN -->
                            <div class="modal fade" id="updatePinModal<?= $s['id_santri'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary text-white">
                                            <h5 class="modal-title"><i class="fas fa-key"></i> Perbarui PIN - <?= esc($s['nama']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?= base_url('santri/updatePin/' . $s['id_santri']) ?>" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">PIN Lama</label>
                                                    <input type="password" name="pin_lama" class="form-control" minlength="6" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">PIN Baru</label>
                                                    <input type="password" name="pin_baru" class="form-control" minlength="6" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-secondary">
                                                    <i class="fas fa-save"></i> Simpan PIN
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>