<?php

namespace App\Controllers;

use App\Models\TabunganModel;
use App\Models\SantriModel;

class TabunganController extends BaseController
{
    protected $tabunganModel;
    protected $santriModel;

    public function __construct()
    {
        $this->tabunganModel = new TabunganModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $data['tabungan'] = $this->tabunganModel->findAll();
        return view('tabungan/index', $data);
    }

    public function create()
    {
        $data['santri'] = $this->santriModel->findAll();
        return view('tabungan/create', $data);
    }

    public function store()
    {
        $this->tabunganModel->save([
            'id_santri' => $this->request->getPost('id_santri'),
            'saldo' => $this->request->getPost('saldo'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/tabungan')->with('success', 'Tabungan berhasil ditambahkan!');
    }
}
