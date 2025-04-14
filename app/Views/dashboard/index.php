<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="text-primary mb-4"><i class="fas fa-chart-line"></i> Dashboard Admin</h2>

    <!-- Statistik utama -->
    <div class="row mt-4 g-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary"><i class="fas fa-users"></i> Total Santri</h5>
                    <h2 class="fw-bold"> <?= $total_santri ?> </h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-success h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-success"><i class="fas fa-shopping-cart"></i> Total Transaksi</h5>
                    <h2 class="fw-bold"> <?= $total_transaksi ?> </h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-warning h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning"><i class="fas fa-wallet"></i> Total Saldo</h5>
                    <h2 class="fw-bold">Rp <?= number_format($total_saldo, 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-danger h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger"><i class="fas fa-exchange-alt"></i> Transaksi Bulan Ini</h5>
                    <h2 class="fw-bold"> <?= $total_transaksi_bulan ?> </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Transaksi -->
    <div class="row mt-4 g-4">
        <div class="col-12 col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-chart-bar"></i> Grafik Transaksi Bulanan</h5>
                    <canvas id="chartTransaksi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Transaksi Terbaru -->
    <div class="row mt-4 g-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-list"></i> Laporan Transaksi Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>No Santri</th>
                                    <th>Nama Santri</th>
                                    <th>Total Harga</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi_terbaru as $trx) : ?>
                                    <tr>
                                        <td><?= $trx['id_transaksi'] ?></td>
                                        <td><?= $trx['no_santri'] ?></td>
                                        <td><?= $trx['nama_santri'] ?></td>
                                        <td>Rp <?= number_format($trx['total_harga'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php if ($trx['metode_pembayaran'] == 'e-money') : ?>
                                                <span class="badge bg-success"><i class="fas fa-qrcode"></i> E-Money</span>
                                            <?php else : ?>
                                                <span class="badge bg-primary"><i class="fas fa-money-bill-wave"></i> Tunai</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d-m-Y H:i', strtotime($trx['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik transaksi bulanan
    var ctx = document.getElementById('chartTransaksi').getContext('2d');
    var chartTransaksi = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($bulan) ?>,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: <?= json_encode($jumlah_transaksi) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>