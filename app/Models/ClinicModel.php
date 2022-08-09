<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicModel extends Model
{
    protected $table            = 'tb_klinik';
    protected $primaryKey       = 'id_klinik';
    protected $allowedFields    = [
        'nama_klinik'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
