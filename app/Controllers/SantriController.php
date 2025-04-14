<?php

namespace App\Controllers;

use App\Models\SantriModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;


class SantriController extends Controller
{
    protected $santriModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $this->santriModel->groupStart()
                ->like('no_santri', $keyword)
                ->orLike('nama', $keyword)
                ->orLike('kelas', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Data Santri',
            'santri' => $this->santriModel->findAll(),
            'keyword' => $keyword, // Menyimpan keyword untuk input pencarian
        ];

        return view('santri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Santri'
        ];
        return view('santri/create', $data);
    }

    public function store()
    {
        // Validasi input
        if (!$this->validate([
            'no_santri' => 'required|is_unique[santri.no_santri]',
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'no_telp' => 'required|numeric',
            'kelas' => 'required',
            'unit_pendidikan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid atau sudah ada.');
        }

        // Simpan data santri
        $this->santriModel->save([
            'no_santri' => $this->request->getPost('no_santri'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'no_telp' => $this->request->getPost('no_telp'),
            'kelas' => $this->request->getPost('kelas'),
            'unit_pendidikan' => $this->request->getPost('unit_pendidikan'),
        ]);

        // Ambil ID santri yang baru ditambahkan
        $id_santri = $this->santriModel->insertID();

        // Periksa apakah data benar-benar tersimpan sebelum redirect
        if (!$id_santri) {
            return redirect()->back()->with('error', 'Gagal menyimpan data santri.');
        }

        // Redirect ke halaman QR Code yang menampilkan detail santri
        return redirect()->to('/qrcode/generate/' . $id_santri);
    }



    public function edit($id_santri)
    {
        $santri = $this->santriModel->find($id_santri);

        if (!$santri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Santri tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Santri'
        ];

        return view('santri/edit', ['santri' => $santri], $data);
    }


    public function update($id_santri)
    {
        $this->santriModel->update($id_santri, [
            'no_santri' => $this->request->getPost('no_santri'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'no_telp' => $this->request->getPost('no_telp'),
            'kelas' => $this->request->getPost('kelas'),
            'unit_pendidikan' => $this->request->getPost('unit_pendidikan'),
        ]);

        session()->setFlashdata('success', 'Santri berhasil diperbarui!');
        return redirect()->to('/santri');
    }

    public function delete($id_santri)
    {
        $santri = $this->santriModel->find($id_santri);
    
        if ($santri) {
            $this->santriModel->delete($id_santri);
            session()->setFlashdata('success', 'Santri berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Santri tidak ditemukan');
        }
    
        return redirect()->to('/santri/index');
    }

    public function exportExcel()
    {
        $santri = $this->santriModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No Santri');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Tempat Lahir');
        $sheet->setCellValue('E1', 'Tanggal Lahir');
        $sheet->setCellValue('F1', 'No Telepon');
        $sheet->setCellValue('G1', 'Kelas');
        $sheet->setCellValue('H1', 'Unit Pendidikan');

        // Isi data
        $row = 2;
        foreach ($santri as $s) {
            $sheet->setCellValue('A' . $row, $s['no_santri']);
            $sheet->setCellValue('B' . $row, $s['nama']);
            $sheet->setCellValue('C' . $row, $s['alamat']);
            $sheet->setCellValue('D' . $row, $s['tempat_lahir']);
            $sheet->setCellValue('E' . $row, $s['tanggal_lahir']);
            $sheet->setCellValue('F' . $row, $s['no_telp']);
            $sheet->setCellValue('G' . $row, $s['kelas']);
            $sheet->setCellValue('H' . $row, $s['unit_pendidikan']);
            $row++;
        }

        // Buat file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Santri.xlsx';

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Tulis file ke output
        $writer->save('php://output');
        exit;
    }

    public function regenerateQr($id_santri)
    {
        $santriModel = new SantriModel();
        $santri = $santriModel->find($id_santri);

        if (!$santri) {
            return redirect()->to('/santri')->with('error', 'Santri tidak ditemukan.');
        }

        // Verifikasi PIN
        $pin = $this->request->getPost('pin');
        if ($santri['pin'] !== $pin) {
            return redirect()->to('/santri')->with('error', 'PIN salah! Tidak dapat melakukan regenerasi QR.');
        }

        // Path tempat menyimpan QR Code
        $filePath = WRITEPATH . 'uploads/qrcodes/' . $id_santri . '.png';

        // Hapus file lama jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Pastikan folder qrcodes ada
        if (!is_dir(WRITEPATH . 'uploads/qrcodes/')) {
            mkdir(WRITEPATH . 'uploads/qrcodes/', 0777, true);
        }

        // Buat QR Code baru
        $qrCode = new \Endroid\QrCode\QrCode('ID Santri: ' . $santri['id_santri']);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $result = $writer->write($qrCode);

        // Simpan QR Code ke file
        $result->saveToFile($filePath);

        return redirect()->to('/santri')->with('success', 'QR Code berhasil diperbarui.');
    }


    public function showQrCode($id_santri)
    {
        $santriModel = new SantriModel();
        $santri = $santriModel->find($id_santri);

        if (!$santri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Santri tidak ditemukan');
        }

        // Path tempat menyimpan QR Code
        $filePath = WRITEPATH . 'uploads/qrcodes/' . $id_santri . '.png';

        // Jika QR Code belum ada, buat baru
        if (!file_exists($filePath)) {
            $qrCode = new QrCode('ID Santri: ' . $santri['id_santri']);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Pastikan folder qrcodes ada
            if (!is_dir(WRITEPATH . 'uploads/qrcodes/')) {
                mkdir(WRITEPATH . 'uploads/qrcodes/', 0777, true);
            }

            // Simpan QR Code ke folder writable
            $result->saveToFile($filePath);
        }

        // Tampilkan QR Code langsung di browser
        header('Content-Type: image/png');
        readfile($filePath);
        exit;
    }

    public function updatePin($id_santri)
    {
        $santri = $this->santriModel->find($id_santri);

        if (!$santri) {
            return redirect()->to('/santri')->with('error', 'Santri tidak ditemukan.');
        }

        $pin_lama = $this->request->getPost('pin_lama');
        $pin_baru = $this->request->getPost('pin_baru');

        if ($santri['pin'] !== $pin_lama) {
            return redirect()->to('/santri')->with('error', 'PIN lama salah, tidak dapat memperbarui.');
        }

        $this->santriModel->update($id_santri, ['pin' => $pin_baru]);

        return redirect()->to('/santri')->with('success', 'PIN berhasil diperbarui.');
    }

    public function downloadQrCode($id_santri)
    {
        $filePath = WRITEPATH . 'uploads/qrcodes/' . $id_santri . '.png';

        if (!file_exists($filePath)) {
            return redirect()->to('/santri')->with('error', 'QR Code tidak ditemukan.');
        }

        return $this->response->download($filePath, null);
    }
}
