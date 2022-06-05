<?php

namespace App\Models;

use CodeIgniter\Model;

class TreatmentModel extends Model
{
    protected $table            = 'tbl_treatment';
    protected $primaryKey       = 'id_treatment';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_treatment',
        'id_clinic',
        'treatment_name',
        'description',
        'open_time',
        'close_time'
    ];

    public function getTreatments($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_treatment.*, tbl_clinic.clinic_name');
        $builder->join('tbl_clinic', 'tbl_clinic.id_clinic = tbl_treatment.id_clinic', 'left');

        if ($id !== NULL) {
            $builder->where('tbl_treatment.id_treatment', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
