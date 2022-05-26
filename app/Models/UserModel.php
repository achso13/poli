<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tbl_users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_role',
        'id_clinic',
        'fullname',
        'username',
        'email',
        'password',
        'photo',
        'is_active',
    ];

    public function getUsers($id = 1)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_users.*, tbl_roles.role, tbl_clinic.clinic_name');
        $builder->join('tbl_roles', 'tbl_roles.id = tbl_users.id_role');
        $builder->join('tbl_clinic', 'tbl_clinic.id = tbl_users.id_clinic', 'left');
        $builder->where('tbl_users.id_role', $id);

        return $builder->get()->getResultArray();
    }
}
