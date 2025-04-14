<?php

namespace App\Controllers;

use App\Models\SantriModel;
use App\Models\TransaksiModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TransaksiController extends Controller
{
    protected $santriModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $transaksiModel = new TransaksiModel();
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $transaksiModel->groupStart()
                ->like('no_santri', $keyword)
                ->orLike('nama_santri', $keyword)
                ->orLike('metode_pembayaran', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Riwayat Transaksi',
            'transaksi' => $transaksiModel->findAll(),
            'keyword' => $keyword
        ];

        return view('transaksi/index', $data);
    }

    public function tambah()
    {
        $santriModel = new SantriModel();

        // Ambil no santri dari URL
        $noSantri = $this->request->getGet('no_santri') ?? '';

        // Ambil data santri jika ada
        $santriData = $noSantri ? $santriModel->where('no_santri', $noSantri)->first() : null;

        $data = [
            'title' => 'Tambah Transaksi',
            'santri' => $santriModel->findAll(),
            'noSantri' => $noSantri,
            'santriData' => $santriData
        ];

        return view('transaksi/create', $data);
    }


    public function proses()
    {
        $transaksiModel = new TransaksiModel();
        $santriModel = new SantriModel();

        $no_santri = $this->request->getPost('no_santri');
        $total_harga = (int) $this->request->getPost('total_harga');
        $metode_pembayaran = $this->request->getPost('metode_pembayaran');
        $pin = $this->request->getPost('pin');

        // Ambil data santri berdasarkan nomor santri
        $santri = $santriModel->where('no_santri', $no_santri)->first();

        if (!$santri) {
            return redirect()->back()->with('error', 'Santri tidak ditemukan.');
        }

        // Validasi input
        if (!$no_santri || !$total_harga || !$metode_pembayaran) {
            return redirect()->back()->with('error', 'Harap lengkapi semua data.');
        }

        // Validasi metode pembayaran e-money (PIN dan saldo)
        if ($metode_pembayaran === 'e-money') {
            if ($santri['pin'] !== $pin) {
                return redirect()->back()->with('error', 'PIN salah atau tidak valid.');
            }

            if ($santri['saldo'] < $total_harga) {
                return redirect()->back()->with('error', 'Saldo tidak mencukupi.');
            }

            // Kurangi saldo santri setelah validasi berhasil
            $santriModel->update($santri['id_santri'], [
                'saldo' => $santri['saldo'] - $total_harga
            ]);
        }

        // Simpan transaksi
        $transaksiModel->save([
            'no_santri' => $no_santri,
            'nama_santri' => $santri['nama'],
            'total_harga' => $total_harga,
            'metode_pembayaran' => $metode_pembayaran
        ]);

        // Set flashdata untuk menampilkan alert sukses setelah redirect
        session()->setFlashdata('success', 'Transaksi berhasil.');

        // Redirect ke daftar transaksi untuk kembali ke mode scanning QR Code
        return redirect()->to('/transaksi');
    }


    public function delete($id_santri)
    {
        $this->transaksiModel->delete($id_santri);
        return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportExcel()
    {
        $transaksiModel = new TransaksiModel();
        $transaksi = $transaksiModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'ID Transaksi');
        $sheet->setCellValue('B1', 'No Santri');
        $sheet->setCellValue('C1', 'Nama Santri');
        $sheet->setCellValue('D1', 'Total Harga');
        $sheet->setCellValue('E1', 'Metode Pembayaran');
        $sheet->setCellValue('F1', 'Tanggal');

        // Isi data
        $row = 2;
        foreach ($transaksi as $trx) {
            $sheet->setCellValue('A' . $row, $trx['id_transaksi']);
            $sheet->setCellValue('B' . $row, $trx['no_santri']);
            $sheet->setCellValue('C' . $row, $trx['nama_santri']);
            $sheet->setCellValue('D' . $row, $trx['total_harga']);
            $sheet->setCellValue('E' . $row, ucfirst($trx['metode_pembayaran']));
            $sheet->setCellValue('F' . $row, date('d-m-Y H:i', strtotime($trx['created_at'])));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Riwayat_Transaksi_' . date('YmdHis') . '.xlsx';

        // Set header response untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
