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
    ];
    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
