<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- Header Halaman -->
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fw-bold text-primary"><i class="fas fa-qrcode"></i> Tambah Transaksi</h2>
                <p class="lead text-muted">Lakukan transaksi dengan mudah menggunakan QR Code atau input manual.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Panel Scanner QR Code -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3"><i class="fas fa-camera fa-lg"></i> Scan QR Code</h5>
                        <div class="ratio ratio-16x9">
                            <video id="qr-video" class="rounded" playsinline autoplay></video>
                        </div>
                        <p class="text-center text-muted mt-3"><small>Pastikan kamera diizinkan untuk membaca QR Code.</small></p>
                    </div>
                </div>
            </div>

            <!-- Panel Form Transaksi -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form id="transaksi-form" action="<?= base_url('transaksi/proses') ?>" method="post">
                            <!-- Pilih Santri -->
                            <div class="mb-3">
                                <label for="no_santri" class="form-label"><i class="fas fa-user-graduate"></i> Pilih Santri</label>
                                <select name="no_santri" id="no_santri" class="form-select" required>
                                    <option value="" data-saldo="0">-- Pilih Santri --</option>
                                    <?php foreach ($santri as $s): ?>
                                        <option value="<?= esc($s['no_santri']) ?>" data-nama="<?= esc($s['nama']) ?>" data-saldo="<?= esc($s['saldo']) ?>">
                                            <?= esc($s['no_santri']) ?> - <?= esc($s['nama']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Nama Santri -->
                            <div class="mb-3">
                                <label for="nama_santri" class="form-label"><i class="fas fa-user"></i> Nama Santri</label>
                                <input type="text" id="nama_santri" name="nama_santri" class="form-control" readonly>
                            </div>
                            <!-- Saldo Santri -->
                            <div class="mb-3">
                                <label for="saldo_santri" class="form-label"><i class="fas fa-wallet"></i> Saldo Santri</label>
                                <input type="text" id="saldo_santri" class="form-control" readonly>
                            </div>
                            <!-- Total Harga -->
                            <div class="mb-3">
                                <label for="total_harga" class="form-label"><i class="fas fa-dollar-sign"></i> Total Harga</label>
                                <input type="number" name="total_harga" id="total_harga" class="form-control" required>
                            </div>
                            <!-- Metode Pembayaran -->
                            <div class="mb-3">
                                <label for="metode_pembayaran" class="form-label"><i class="fas fa-credit-card"></i> Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                    <option value="tunai">Tunai</option>
                                    <option value="e-money">E-Money (QR Code)</option>
                                </select>
                            </div>
                            <!-- Input PIN (hanya muncul jika e-money) -->
                            <div class="mb-3 d-none" id="pin-section">
                                <label for="pin" class="form-label"><i class="fas fa-key"></i> Masukkan PIN Santri</label>
                                <input type="password" name="pin" id="pin" class="form-control" minlength="6">
                            </div>
                            <!-- Tombol Proses & Kembali -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Proses Transaksi</button>
                                <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load ZXing Library -->
<script src="https://unpkg.com/@zxing/library@latest"></script>

<script>
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
                            let noSantriDropdown = document.getElementById('no_santri');
                            let found = false;

                            for (let option of noSantriDropdown.options) {
                                if (option.value.trim() === noSantri) {
                                    option.selected = true;
                                    document.getElementById('nama_santri').value = option.getAttribute('data-nama');
                                    document.getElementById('saldo_santri').value = `Rp ${parseInt(option.getAttribute('data-saldo')).toLocaleString("id-ID")}`;
                                    document.getElementById('metode_pembayaran').value = "e-money";
                                    document.getElementById('pin-section').classList.remove('d-none');
                                    found = true;
                                    codeReader.reset();
                                    break;
                                }
                            }
                            if (!found) {
                                Swal.fire("Error", "Santri dengan ID " + noSantri + " tidak ditemukan.", "error");
                            }
                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error(err);
                        }
                    });
                }
            })
            .catch(err => Swal.fire("Error", "Gagal mengakses kamera: " + err, "error"));
    }

    startScan();

    document.getElementById('metode_pembayaran').addEventListener('change', function() {
        document.getElementById('pin-section').classList.toggle('d-none', this.value !== 'e-money');
    });

    document.getElementById('no_santri').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('nama_santri').value = selectedOption.getAttribute('data-nama');
        document.getElementById('saldo_santri').value = `Rp ${parseInt(selectedOption.getAttribute('data-saldo')).toLocaleString("id-ID")}`;
    });

    document.getElementById('transaksi-form').addEventListener('submit', function(event) {
        let saldo = parseInt(document.getElementById('saldo_santri').value.replace(/\D/g, ''));
        let totalHarga = parseInt(document.getElementById('total_harga').value);

        if (saldo < totalHarga) {
            event.preventDefault();
            Swal.fire("Saldo Tidak Cukup", "Saldo santri tidak mencukupi untuk transaksi ini.", "error");
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let noSantri = "<?= isset($noSantri) ? esc($noSantri) : '' ?>";
        let namaSantri = "<?= isset($santriData['nama']) ? esc($santriData['nama']) : '' ?>";
        let saldoSantri = "<?= isset($santriData['saldo']) ? esc($santriData['saldo']) : 0 ?>";

        if (noSantri !== "") {
            document.getElementById('no_santri').value = noSantri;
            document.getElementById('nama_santri').value = namaSantri;
            document.getElementById('saldo_santri').value = `Rp ${parseInt(saldoSantri).toLocaleString("id-ID")}`;
            document.getElementById('metode_pembayaran').value = "e-money";
            document.getElementById('pin-section').classList.remove('d-none');

            // Jika e-money, aktifkan input otomatis
            document.getElementById('metode_pembayaran').dispatchEvent(new Event('change'));
        }
    });
</script>



<?= $this->endSection() ?>