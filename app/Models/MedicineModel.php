<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table            = 'tb_obat';
    protected $primaryKey       = 'id_obat';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_obat',
        'nama_obat',
        'stok',
        'satuan',
        'masa_kadaluarsa',
    ];
    protected $useTimestamps = true;

    public function addStock($id_obat, $jumlah)
    {
        $oldStock = $this->find($id_obat)["stok"];
        $newStock = $oldStock + $jumlah;
        return $this->update($id_obat, ['stok' => $newStock]);
    }

    public function removeStock($id_obat, $jumlah)
    {
        $oldStock = $this->find($id_obat)["stok"];
        $newStock = $oldStock - $jumlah;

        return $this->update($id_obat, ['stok' => $newStock]);
    }
}
