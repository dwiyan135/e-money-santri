function confirmDelete(event) {
    event.preventDefault(); // Mencegah form dari pengiriman otomatis
    const form = event.target;

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Kirim form jika konfirmasi
        }
    });
}
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let transaksiId = this.getAttribute("data-id");

            Swal.fire({
                title: "Hapus Transaksi?",
                text: "Transaksi ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6"
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('transaksi/hapus/') ?>" + transaksiId;
                }
            });
        });
    });
});