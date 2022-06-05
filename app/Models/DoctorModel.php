<?php

namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table            = 'tbl_doctor';
    protected $primaryKey = 'id_doctor';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_doctor',
        'id_user',
        'fullname',
        'doctor_type',
        'education',
    ];

    public function getDoctors($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_doctor.*, tbl_users.username, tbl_users.email, tbl_users.photo');
        $builder->join('tbl_users', 'tbl_users.id = tbl_doctor.id_user', 'left');

        if ($id !== NULL) {
            $builder->where('tbl_doctor.id_doctor', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
