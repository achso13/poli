<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tbl_users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_role',
        'id_departement',
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
        $builder->select('tbl_users.*, tbl_roles.role, tbl_departement.departement_name');
        $builder->join('tbl_roles', 'tbl_roles.id = tbl_users.id_role');
        $builder->join('tbl_departement', 'tbl_departement.id = tbl_users.id_departement', 'left');
        $builder->where('tbl_users.id_role', $id);

        return $builder->get()->getResultArray();
    }
}
