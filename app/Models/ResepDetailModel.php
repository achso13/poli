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

    public function getReportResep($date)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_resep_detail.*, tb_obat.nama_obat, tb_obat.satuan, tb_pasien.nama as nama_pasien, tb_kunjungan.id_kunjungan');
        $builder->join('tb_obat', 'tb_resep_detail.id_obat = tb_obat.id_obat');
        $builder->join('tb_resep', 'tb_resep_detail.id_resep = tb_resep.id_resep');
        $builder->join("tb_rekam_medis", "tb_resep.id_rekam_medis = tb_rekam_medis.id_rekam_medis");
        $builder->join('tb_kunjungan', 'tb_rekam_medis.id_kunjungan = tb_kunjungan.id_kunjungan');
        $builder->join('tb_pasien', 'tb_kunjungan.id_pasien = tb_pasien.id_pasien');

        $tanggalAwal = $date[0];
        $tanggalAkhir = $date[1];

        $builder->where("tb_resep_detail.created_at >=", $tanggalAwal);
        $builder->where("tb_resep_detail.created_at <=", $tanggalAkhir);

        $builder->orderBy('tb_resep_detail.id_resep_detail', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
