<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? '' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="/assets/sweetalert/css/sweetalert2.min.css" />
</head>

<body class="bg-light">
    <!-- Wrapper untuk Sidebar & Content -->
    <div class="d-flex" id="wrapper" style="min-height: 100vh;">

        <!-- Sidebar -->
        <nav class="bg-dark text-white shadow-sm d-flex flex-column p-3 d-md-block" id="sidebarMenu" style="width: 260px;">
            <!-- Brand -->
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-university text-warning fs-4 me-2"></i>
                <span class="fw-bold text-white fst-italic">E-Money Santri</span>
            </div>

            <hr class="border-secondary">

            <!-- Info Pengguna -->
            <div class="text-white mb-3">
                <small class="fst-italic">
                    Selamat datang, <span class="text-warning"><?= session('nama_lengkap') ?></span>
                </small><br>
                <small class="text-secondary fst-italic">
                    Login sebagai: <?= session('level') ?>
                </small>
            </div>

            <!-- Menu -->
            <ul class="nav nav-pills flex-column mb-auto">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link text-white d-flex align-items-center">
                        <i class="fas fa-home me-2"></i> <span class="fst-italic">Dashboard</span>
                    </a>
                </li>

                <!-- Data Santri -->
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#santriMenu">
                        <i class="fas fa-user-graduate me-2"></i> <span class="fst-italic">Data Santri</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="santriMenu">
                        <ul class="nav flex-column ps-3">
                            <li><a href="/santri" class="nav-link text-white fst-italic">📋 Main Data</a></li>
                            <li><a href="/santri/create" class="nav-link text-white fst-italic">➕ Tambah Santri</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Top-Up Saldo -->
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#topupMenu">
                        <i class="fas fa-wallet me-2"></i> <span class="fst-italic">Top-Up Saldo</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="topupMenu">
                        <ul class="nav flex-column ps-3">
                            <li><a href="/topup" class="nav-link text-white fst-italic">📋 Main Top-Up</a></li>
                            <li><a href="/topup/create" class="nav-link text-white fst-italic">➕ Tambah Top-Up</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Transaksi -->
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#transaksiMenu">
                        <i class="fas fa-exchange-alt me-2"></i> <span class="fst-italic">Transaksi</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="transaksiMenu">
                        <ul class="nav flex-column ps-3">
                            <li><a href="/transaksi" class="nav-link text-white fst-italic">📋 Daftar Transaksi</a></li>
                            <li><a href="/transaksi/tambah" class="nav-link text-white fst-italic">➕ Tambah Transaksi</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Logout -->
                <li class="mt-2">
                    <a href="/auth/logout" class="nav-link text-danger fw-semibold d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i> <span class="fst-italic">Logout</span>
                    </a>
                </li>
            </ul>

            <hr class="border-secondary">

            <!-- Footer Sidebar -->
            <div class="text-center text-secondary fst-italic">
                <small>© 2025 E-Money Santri</small>
            </div>
        </nav>
        <!-- /Sidebar -->

        <!-- Main Content -->
        <div id="page-content-wrapper" class="flex-grow-1 p-3 p-lg-4">
            <!-- Tombol toggle untuk mobile -->
            <button class="btn btn-primary d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="/assets/fontawesome/js/all.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/assets/sweetalert/js/sweetalert2.min.js"></script>
    <script src="/assets/js/sweetalert2.js"></script>

    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script src="<?= base_url('assets/js/qr-scanner.js') ?>"></script>

    <!-- Script untuk mengaktifkan offcanvas dan menutup sidebar di mobile -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector("#sidebarMenu");
            const mediaQuery = window.matchMedia("(max-width: 767.98px)");
            const navLinks = sidebar.querySelectorAll(".nav-link:not([data-bs-toggle='collapse'])");

            function handleMobileView(e) {
                if (e.matches) {
                    // Aktifkan offcanvas di mobile
                    sidebar.classList.add("offcanvas", "offcanvas-start");
                } else {
                    // Nonaktifkan offcanvas di desktop
                    sidebar.classList.remove("offcanvas", "offcanvas-start");
                }
            }

            // Jalankan saat halaman dimuat
            handleMobileView(mediaQuery);
            // Dengarkan perubahan ukuran layar
            mediaQuery.addEventListener("change", handleMobileView);

            // Tambahkan event listener untuk menutup sidebar saat link diklik di mobile
            navLinks.forEach(link => {
                link.addEventListener("click", function () {
                    if (mediaQuery.matches) {
                        const offcanvas = bootstrap.Offcanvas.getInstance(sidebar) || new bootstrap.Offcanvas(sidebar);
                        offcanvas.hide();
                    }
                });
            });
        });
    </script>

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.createElement("video");
            video.style.position = "fixed";
            video.style.bottom = "10px";
            video.style.right = "10px";
            video.style.width = "200px";
            video.style.height = "150px";
            video.style.border = "2px solid #007bff";
            video.style.zIndex = "9999";
            document.body.appendChild(video);

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

                            codeReader.decodeFromVideoDevice(selectedDeviceId, video, (result, err) => {
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
    </script> -->
</body>

</html>