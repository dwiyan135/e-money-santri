<?php

namespace App\Controllers;

use App\Models\SantriModel;
use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class DashboardController extends BaseController
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $santriModel = new SantriModel();
        $transaksiModel = new TransaksiModel();

        // Statistik utama
        $total_santri = $santriModel->countAll();
        $total_transaksi = $transaksiModel->countAll();
        $total_saldo = $santriModel->selectSum('saldo')->first()['saldo'];
        $total_transaksi_bulan = $transaksiModel
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();

        // Ambil transaksi terbaru (limit 5)
        $transaksi_terbaru = $transaksiModel
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        // Ambil data untuk grafik transaksi bulanan
        $bulan = [];
        $jumlah_transaksi = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = date('F', mktime(0, 0, 0, $i, 1));
            $jumlah_transaksi[] = $transaksiModel
                ->where('MONTH(created_at)', $i)
                ->where('YEAR(created_at)', date('Y'))
                ->countAllResults();
        }

        $data = [
            'title' => 'Dashboard Admin',
            'total_santri' => $total_santri,
            'total_transaksi' => $total_transaksi,
            'total_saldo' => $total_saldo,
            'total_transaksi_bulan' => $total_transaksi_bulan,
            'transaksi_terbaru' => $transaksi_terbaru,
            'bulan' => $bulan,
            'jumlah_transaksi' => $jumlah_transaksi
        ];

        // Tampilkan halaman dashboard
        return view('dashboard/index', $data);
    }
}
