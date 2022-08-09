<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalDokterModel extends Model
{
    protected $table            = 'tb_jadwal_dokter';
    protected $primaryKey       = 'id_jadwal_dokter';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_dokter',
        'jam_mulai',
        'jam_selesai',
        'keterangan'
    ];

    public function getJadwal($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_jadwal_dokter.*, tb_dokter.nama, tb_dokter.tipe_dokter');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_jadwal_dokter.id_dokter', 'left');
        if ($id != null) {
            $builder->where('tb_jadwal_dokter.id_jadwal_dokter', $id);
            return $builder->get()->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
