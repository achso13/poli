<?php

namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table            = 'tbl_dokter';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [];
}
