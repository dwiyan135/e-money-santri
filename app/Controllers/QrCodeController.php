<?php

namespace App\Controllers;

use App\Models\SantriModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends BaseController
{
    public function generate($id_santri)
    {
        $santriModel = new SantriModel();
        $santri = $santriModel->find($id_santri);

        if (!$santri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Santri tidak ditemukan');
        }

        // Format JSON untuk QR Code
        $qrData = json_encode([
            "no_santri" => $santri['no_santri'],
            "nama_santri" => $santri['nama']
        ]);

        // Path tempat menyimpan QR Code
        $filePath = WRITEPATH . 'uploads/qrcodes/' . $id_santri . '.png';

        // Jika QR Code belum ada, buat baru
        if (!file_exists($filePath)) {
            $qrCode = new QrCode($qrData);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Pastikan folder qrcodes ada
            if (!is_dir(WRITEPATH . 'uploads/qrcodes/')) {
                mkdir(WRITEPATH . 'uploads/qrcodes/', 0777, true);
            }

            // Simpan QR Code ke folder writable
            $result->saveToFile($filePath);
        }

        return view('qrcode/show', [
            'santri' => $santri,
            'qr_image' => base_url('qrcode/generate_img/' . $id_santri) // Path gambar QR Code
        ]);
    }

    public function generateImg($id_santri)
    {
        $filePath = WRITEPATH . 'uploads/qrcodes/' . $id_santri . '.png';

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('QR Code tidak ditemukan.');
        }

        // Tampilkan QR Code langsung sebagai gambar
        header('Content-Type: image/png');
        readfile($filePath);
        exit;
    }
}
