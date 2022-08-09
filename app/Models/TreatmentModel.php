<?php

namespace App\Models;

use CodeIgniter\Model;

class TreatmentModel extends Model
{
    protected $table            = 'tb_treatment';
    protected $primaryKey       = 'id_treatment';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_treatment',
        'id_klinik',
        'nama_treatment',
        'deskripsi',
        'jam_buka',
        'jam_tutup'
    ];

    public function getTreatments($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_treatment.*, tb_klinik.nama_klinik');
        $builder->join('tb_klinik', 'tb_klinik.id_klinik = tb_treatment.id_klinik', 'left');

        if ($id !== NULL) {
            $builder->where('tb_treatment.id_treatment', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
