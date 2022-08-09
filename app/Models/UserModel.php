<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id_user';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'id_klinik',
        'role',
        'nama',
        'username',
        'password',
        'email',
        'photo',
    ];

    public function getUsers($role = "ADMIN")
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_user.*, tb_klinik.nama_klinik');
        $builder->join('tb_klinik', 'tb_klinik.id_klinik = tb_user.id_klinik', 'left');
        $builder->where('role', $role);


        return $builder->get()->getResultArray();
    }
}
