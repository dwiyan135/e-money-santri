<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg border-0 p-4 bg-white rounded-4"
            style="backdrop-filter: blur(15px); background: rgba(255, 255, 255, 0.85);">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary"><i class="fas fa-user-graduate"></i> Tambah Santri</h2>
                <p class="text-muted">Silakan isi data santri dengan lengkap</p>
            </div>

            <!-- Pesan Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger shadow-sm">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('santri/store') ?>" method="post" class="needs-validation" novalidate>
                <?php
                $fields = [
                    ['no_santri', 'No Santri', 'fas fa-id-badge'],
                    ['nama', 'Nama Santri', 'fas fa-user'],
                    ['alamat', 'Alamat', 'fas fa-map-marker-alt'],
                    ['tempat_lahir', 'Tempat Lahir', 'fas fa-map-pin'],
                    ['tanggal_lahir', 'Tanggal Lahir', 'fas fa-calendar-alt', 'date'],
                    ['no_telp', 'No Telepon', 'fas fa-phone'],
                    ['kelas', 'Kelas', 'fas fa-school'],
                    ['unit_pendidikan', 'Unit Pendidikan', 'fas fa-graduation-cap'],
                    ['pin', 'PIN Santri', 'fas fa-key', 'password']
                ];
                ?>

                <?php foreach ($fields as $field): ?>
                    <div class="mb-3 input-group">
                        <span class="input-group-text bg-light"><i class="<?= $field[2] ?> text-primary"></i></span>
                        <div class="form-floating">
                            <input type="<?= $field[3] ?? 'text' ?>" name="<?= $field[0] ?>" class="form-control rounded-end"
                                id="<?= $field[0] ?>" placeholder="Masukkan <?= $field[1] ?>" required>
                            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>

                <small class="text-muted d-block mt-2 text-center"><i class="fas fa-info-circle"></i> PIN digunakan untuk transaksi. Bisa diubah oleh admin.</small>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('santri') ?>" class="btn btn-secondary btn-lg fw-bold shadow-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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