<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table            = 'tbl_patient';
    protected $primaryKey       = 'id_patient';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_patient',
        'id_user',
        'nip',
        'fullname',
        'address',
        'phone',
        'blood_type',
        'birth_date',
        'gender',
        'admission_date'
    ];

    public function getPatients($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_patient.*, tbl_users.username, tbl_users.email, tbl_users.photo');
        $builder->join('tbl_users', 'tbl_users.id = tbl_patient.id_user', 'left');

        if ($id !== NULL) {
            $builder->where('tbl_patient.id_patient', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
