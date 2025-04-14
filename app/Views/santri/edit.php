<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-lg-6 col-md-8">
        <!-- Card dengan efek glassmorphism -->
        <div class="card shadow-lg border-0 p-4" style="border-radius: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(240,240,240,0.8)); backdrop-filter: blur(10px);">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary"><i class="fas fa-user-edit"></i> Edit Santri</h2>
                <p class="text-muted">Perbarui informasi santri dengan benar</p>
            </div>
            <form action="<?= base_url('santri/update/' . $santri['id_santri']) ?>" method="post">
                <?php
                // Daftar field yang akan ditampilkan pada form edit
                $fields = [
                    ['no_santri', 'No Santri', 'fas fa-id-badge'],
                    ['nama', 'Nama Santri', 'fas fa-user'],
                    ['alamat', 'Alamat', 'fas fa-map-marker-alt'],
                    ['tempat_lahir', 'Tempat Lahir', 'fas fa-map-pin'],
                    ['tanggal_lahir', 'Tanggal Lahir', 'fas fa-calendar-alt', 'date'],
                    ['no_telp', 'No Telepon', 'fas fa-phone'],
                    ['kelas', 'Kelas', 'fas fa-school'],
                    ['unit_pendidikan', 'Unit Pendidikan', 'fas fa-graduation-cap']
                ];
                ?>

                <?php foreach ($fields as $field): ?>
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="<?= $field[2] ?>"></i></span>
                        <div class="form-floating">
                            <input type="<?= $field[3] ?? 'text' ?>" name="<?= $field[0] ?>" class="form-control" id="<?= $field[0] ?>"
                                value="<?= esc($santri[$field[0]]) ?>"
                                placeholder="Masukkan <?= $field[1] ?>" required>
                            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Update</button>
                    <a href="<?= base_url('santri') ?>" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>