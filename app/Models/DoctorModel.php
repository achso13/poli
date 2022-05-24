<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table            = 'tbl_dokter';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [];

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
}
