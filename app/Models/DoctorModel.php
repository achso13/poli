<?php

namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table            = 'tb_dokter';
    protected $primaryKey = 'id_dokter';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_dokter',
        'id_user',
        'nip',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'tipe_dokter',
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getDoctors($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_dokter.*, tb_user.username, tb_user.email, tb_user.photo');
        $builder->join('tb_user', 'tb_user.id_user = tb_dokter.id_user', 'left');

        if ($id !== NULL) {
            $builder->where('tb_dokter.id_dokter', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
