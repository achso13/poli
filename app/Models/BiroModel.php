<?php

namespace App\Models;

use CodeIgniter\Model;

class BiroModel extends Model
{
    protected $table            = 'tb_biro';
    protected $primaryKey       = 'id_biro';

    protected $allowedFields    = [
        'nama_biro'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
