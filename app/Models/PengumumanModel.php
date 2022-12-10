<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_pengumuman';
    protected $primaryKey       = 'id_pengumuman';
    protected $useAutoIncrement = true;
    protected $protectFields    = false;

    // Dates
    protected $useTimestamps = true;

    public function getPengumuman($id = false, $limit = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_pengumuman.*, tb_user.nama');
        $builder->join('tb_user', 'tb_pengumuman.id_user = tb_user.id_user');
        if ($limit != false) {
            $builder->limit($limit);
        }
        $builder->orderBy('tb_pengumuman.id_pengumuman', 'DESC');
        if ($id != false) {
            $builder->where('tb_pengumuman.id_pengumuman', $id);
            return $builder->get()->getRowArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }
}
