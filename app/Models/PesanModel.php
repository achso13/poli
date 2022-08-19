<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanModel extends Model
{
    protected $table            = 'tb_pesan';
    protected $primaryKey       = 'id_pesan';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_pesan',
        'id_user',
        'id_kunjungan',
        'pesan'
    ];

    // Dates
    protected $useTimestamps = true;

    public function getPesan($idKunjungan)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_pesan.*, tb_user.nama as nama_user, tb_user.photo');
        $builder->join('tb_user', 'tb_pesan.id_user = tb_user.id_user');

        $builder->where('tb_pesan.id_kunjungan', $idKunjungan);

        return $builder->get()->getResultArray();
    }
}
