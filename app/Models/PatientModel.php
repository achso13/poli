<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table            = 'tb_pasien';
    protected $primaryKey       = 'id_pasien';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_pasien',
        'id_user',
        'id_unitkerja',
        'nip',
        'nama',
        'alamat_rumah',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPatients($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_pasien.*, tb_user.username, tb_user.email, tb_user.photo, tb_unitkerja.nama_bagian, tb_biro.*');
        $builder->join('tb_user', 'tb_user.id_user = tb_pasien.id_user', 'left');
        $builder->join('tb_unitkerja', 'tb_unitkerja.id_unitkerja = tb_pasien.id_unitkerja', 'left');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');

        if ($id !== NULL) {
            $builder->where('tb_pasien.id_pasien', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
