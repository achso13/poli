<?php

namespace App\Models;

use CodeIgniter\Model;

class ClinicModel extends Model
{
    protected $table            = 'tbl_clinic';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'clinic_name',
        'description',
    ];
}
