<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table            = 'tbl_rekam_medis';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [];

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
}
