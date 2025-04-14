<?php

namespace App\Controllers;

use App\Models\TopupModel;
use App\Models\SantriModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TopupController extends Controller
{
    protected $topupModel;
    protected $santriModel; // Inisialisasi SantriModel
    protected $userModel; // Inisialisasi UserModel

    public function __construct()
    {
        $this->topupModel = new TopupModel();
        $this->santriModel = new SantriModel(); // Ambil data santri
        $this->userModel = new UserModel(); // Ambil data user
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $topups = $this->topupModel->getTopups($keyword);

        $data = [
            'title' => 'Riwayat Top-Up',
            'topups' => $topups,
            'pager' => $this->topupModel->pager,
            'keyword' => $keyword
        ];

        return view('topup/index', $data);
    }

    public function create()
    {
        // Mengambil data santri untuk dropdown no_santri
        $santris = $this->santriModel->findAll();

        // Mengambil data admin dari tabel users
        $users = $this->userModel->where('level', 'admin')->findAll();

        $data = [
            'title' => 'Tambah Top-Up',
            'santris' => $santris,
            'users' => $users,
            'metode_pembayaran' => ['Tunai', 'Transfer', 'Debit', 'E-wallet'], // Contoh metode pembayaran
        ];

        return view('topup/create', $data);
    }

    public function store()
    {
        // Ambil data id_santri dan pin yang dimasukkan
        $idSantri = $this->request->getPost('no_santri'); // Ambil id_santri dari form
        $pinMasuk = $this->request->getPost('pin');

        // Cari santri berdasarkan id_santri
        $santri = $this->santriModel->where('id_santri', $idSantri)->first();

        // Cek apakah pin yang dimasukkan sesuai dengan pin santri
        if ($santri && $santri['pin'] != $pinMasuk) {
            // Jika pin salah, kirim pesan error dan kembalikan ke form
            session()->setFlashdata('error', 'PIN yang Anda masukkan salah.');
            return redirect()->back()->withInput();
        }

        // Data top-up
        $data = [
            'id_santri' => $idSantri,  // Gunakan id_santri untuk top-up
            'nama' => $this->request->getPost('nama'),
            'nominal' => $this->request->getPost('nominal'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'admin' => $this->request->getPost('admin'),
            'tanggal' => date('Y-m-d H:i:s'), // Menyimpan waktu sekarang
        ];

        // Menyimpan data top-up
        $this->topupModel->save($data);

        // Update saldo santri (tambahkan nominal ke saldo)
        $newSaldo = $santri['saldo'] + $this->request->getPost('nominal');
        $this->santriModel->update($santri['id_santri'], ['saldo' => $newSaldo]);

        // Pesan sukses
        session()->setFlashdata('success', 'Top-Up berhasil ditambahkan');
        return redirect()->to(base_url('topup'));
    }

    public function exportExcel()
    {
        $topups = $this->topupModel->exportTopups();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No Santri');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Nominal');
        $sheet->setCellValue('D1', 'Metode Pembayaran');
        $sheet->setCellValue('E1', 'Admin');
        $sheet->setCellValue('F1', 'Tanggal');

        // Isi data
        $row = 2;
        foreach ($topups as $t) {
            $sheet->setCellValue('A' . $row, $t['no_santri']);
            $sheet->setCellValue('B' . $row, $t['nama']);
            $sheet->setCellValue('C' . $row, 'Rp ' . number_format($t['nominal'], 2, ',', '.'));
            $sheet->setCellValue('D' . $row, $t['metode_pembayaran']);
            $sheet->setCellValue('E' . $row, $t['admin']);
            $sheet->setCellValue('F' . $row, $t['tanggal']);
            $row++;
        }

        // Buat file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Riwayat_TopUp.xlsx';

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Tulis file ke output
        $writer->save('php://output');
        exit;
    }
}
