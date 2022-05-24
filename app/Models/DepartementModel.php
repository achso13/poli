<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table            = 'tbl_departement';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [];

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
}
