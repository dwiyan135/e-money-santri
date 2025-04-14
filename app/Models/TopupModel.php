<?php

namespace App\Models;

use CodeIgniter\Model;

class TopupModel extends Model
{
    protected $table = 'topup';
    protected $primaryKey = 'id_topup';
    protected $allowedFields = ['id_santri', 'nominal', 'metode_pembayaran', 'admin', 'tanggal'];

    // Method to get topups with an optional keyword for searching
    public function getTopups($keyword = null)
    {
        $builder = $this->select('topup.*, santri.no_santri, santri.nama')
            ->join('santri', 'santri.id_santri = topup.id_santri')
            ->orderBy('topup.tanggal', 'DESC');

        if ($keyword) {
            $builder->like('santri.nama', $keyword)
                ->orLike('santri.no_santri', $keyword);
        }

        return $builder->findAll();
    }

    // Method to export topups (can be used in the controller for Excel export)
    public function exportTopups()
    {
        return $this->select('topup.*, santri.no_santri, santri.nama')
            ->join('santri', 'santri.id_santri = topup.id_santri')
            ->findAll();
    }
}
