<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitKerjaModel extends Model
{
    protected $table            = 'tb_unitkerja';
    protected $primaryKey       = 'id_unitkerja';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_bagian',
        'id_biro',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUnitKerja($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_unitkerja.*, tb_biro.nama_biro');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');
        if ($id != NULL) {
            $builder->where('tb_unitkerja.id_unitkerja', $id);
            return $builder->get()->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
