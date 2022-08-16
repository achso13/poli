<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepDetailModel extends Model
{
    protected $table            = 'tb_resep_detail';
    protected $primaryKey       = 'id_resep_detail';
    protected $allowedFields    = [
        'id_resep',
        'id_obat',
        'jumlah',
        'keterangan',
    ];

    protected $useTimestamps    = true;

    public function getResepDetail($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_resep_detail.*, tb_obat.nama_obat, tb_obat.satuan');
        $builder->join('tb_obat', 'tb_resep_detail.id_obat = tb_obat.id_obat');
        if ($id != NULL) {
            $builder->where('tb_resep_detail.id_resep', $id);
        }

        $builder->orderBy('tb_resep_detail.id_resep_detail', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
