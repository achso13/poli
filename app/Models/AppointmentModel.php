<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table            = 'tbl_appointment';
    protected $primaryKey       = 'id_appointment';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_dokter',
        'id_user',
        'nama',
        'tipe_dokter',
        'education',
    ];
}
