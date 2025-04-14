<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg border-0 p-4 bg-white rounded-4"
            style="backdrop-filter: blur(15px); background: rgba(255, 255, 255, 0.85);">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary"><i class="fas fa-wallet"></i> Tambah Top-Up</h2>
                <p class="text-muted">Silakan isi data top-up dengan lengkap</p>
            </div>

            <!-- Pesan Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger shadow-sm">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('topup/store') ?>" method="post" class="needs-validation" novalidate>
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                    <div class="form-floating">
                        <select name="no_santri" class="form-control rounded-end" id="no_santri" required>
                            <option value="">Pilih Nama Santri</option>
                            <?php foreach ($santris as $santri): ?>
                                <option value="<?= esc($santri['no_santri']) ?>" data-nama="<?= esc($santri['nama']) ?>">
                                    <?= esc($santri['nama']) ?> - <?= esc($santri['no_santri']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="no_santri">Nama Santri</label>
                    </div>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                    <div class="form-floating">
                        <input type="text" name="nama" class="form-control rounded-end" id="nama"
                            placeholder="Nama Santri" required readonly>
                        <label for="nama">Nama</label>
                    </div>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-money-bill-wave text-success"></i></span>
                    <div class="form-floating">
                        <input type="number" name="nominal" class="form-control rounded-end" id="nominal"
                            placeholder="Masukkan Nominal Top-Up" required>
                        <label for="nominal">Nominal</label>
                    </div>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-credit-card text-warning"></i></span>
                    <div class="form-floating">
                        <select name="metode_pembayaran" class="form-control rounded-end" id="metode_pembayaran"
                            required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <?php foreach ($metode_pembayaran as $metode): ?>
                                <option value="<?= esc($metode) ?>"><?= esc($metode) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="metode_pembayaran">Metode Pembayaran</label>
                    </div>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-user-shield text-dark"></i></span>
                    <div class="form-floating">
                        <select name="admin" class="form-control rounded-end" id="admin" required>
                            <option value="">Pilih Admin</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= esc($user['nama_lengkap']) ?>">
                                    <?= esc($user['nama_lengkap']) ?> (<?= esc($user['level']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="admin">Admin</label>
                    </div>
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-key text-danger"></i></span>
                    <div class="form-floating">
                        <input type="password" name="pin" class="form-control rounded-end" id="pin"
                            placeholder="Masukkan PIN Santri" required>
                        <label for="pin">PIN</label>
                    </div>
                </div>

                <!-- Hidden Field untuk no_santri -->
                <input type="hidden" name="no_santri" id="no_santri_hidden">

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('topup') ?>" class="btn btn-secondary btn-lg fw-bold shadow-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Menangani perubahan pada pilihan nama santri
    document.getElementById('no_santri').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var selectedNama = selectedOption.getAttribute('data-nama');
        document.getElementById('nama').value = selectedNama;
        document.getElementById('no_santri_hidden').value = selectedOption.value;
    });

    // Validasi Form Bootstrap 5
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?= $this->endSection() ?>
