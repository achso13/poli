<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table            = 'tbl_medicine';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'medicine_name',
        'description',
        'stock',
        'unit',
        'created_at',
        'updated_at',
    ];
}
