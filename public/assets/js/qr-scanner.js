document.addEventListener("DOMContentLoaded", function () {
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
                            let transaksiURL = `http://localhost:8080/transaksi/tambah?no_santri=${noSantri}`;

                            // **Fokus kembali ke tab Chrome jika memungkinkan**
                            if (document.hidden) {
                                window.focus();
                            }

                            // **Redirect langsung jika tab aktif**
                            if (!document.hidden) {
                                window.location.href = transaksiURL;
                            } else {
                                // **Jika tab tidak aktif, kirim notifikasi**
                                if (Notification.permission === "granted") {
                                    let notification = new Notification("Scan Berhasil", {
                                        body: "Klik untuk masuk ke transaksi",
                                        icon: "https://your-website.com/icon.png"
                                    });

                                    notification.onclick = function () {
                                        window.focus(); // Fokus kembali ke Chrome saat notifikasi diklik
                                        window.location.href = transaksiURL; // Pastikan masuk ke halaman yang benar
                                    };
                                } else {
                                    Notification.requestPermission().then(permission => {
                                        if (permission === "granted") {
                                            let notification = new Notification("Scan Berhasil", {
                                                body: "Klik untuk masuk ke transaksi",
                                                icon: "https://your-website.com/icon.png"
                                            });

                                            notification.onclick = function () {
                                                window.focus();
                                                window.location.href = transaksiURL; // Perbaikan: Redirect ke transaksi
                                            };
                                        }
                                    });
                                }
                            }
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
