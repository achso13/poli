<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepModel extends Model
{
    protected $table            = 'tb_resep';
    protected $primaryKey       = 'id_resep';
    protected $allowedFields    = [
        'id_rekam_medis',
        'resep_dokter',
        'status'
    ];

    protected $useTimestamps    = true;

    public function getResep($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_resep.*, tb_rekam_medis.id_rekam_medis, tb_rekam_medis.id_pasien, tb_rekam_medis.id_dokter, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter, tb_kunjungan.tanggal_kunjungan, tb_kunjungan.id_kunjungan, tb_unitkerja.nama_bagian, tb_biro.nama_biro');
        $builder->join('tb_rekam_medis', 'tb_rekam_medis.id_rekam_medis = tb_resep.id_rekam_medis');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_rekam_medis.id_pasien');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_rekam_medis.id_dokter');
        $builder->join('tb_kunjungan', 'tb_kunjungan.id_kunjungan = tb_rekam_medis.id_kunjungan');
        $builder->join('tb_unitkerja', 'tb_unitkerja.id_unitkerja = tb_pasien.id_unitkerja', 'left');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');
        if ($id != NULL) {
            $builder->where('tb_resep.id_resep', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }

    public function getResepByPasien($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_resep.*, tb_rekam_medis.id_rekam_medis, tb_rekam_medis.id_pasien, tb_rekam_medis.id_dokter, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter, tb_kunjungan.tanggal_kunjungan, tb_kunjungan.id_kunjungan, tb_unitkerja.nama_bagian, tb_biro.nama_biro');
        $builder->join('tb_rekam_medis', 'tb_rekam_medis.id_rekam_medis = tb_resep.id_rekam_medis');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_rekam_medis.id_pasien');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_rekam_medis.id_dokter');
        $builder->join('tb_kunjungan', 'tb_kunjungan.id_kunjungan = tb_rekam_medis.id_kunjungan');
        $builder->join('tb_unitkerja', 'tb_unitkerja.id_unitkerja = tb_pasien.id_unitkerja', 'left');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');
        $builder->where('tb_rekam_medis.id_pasien', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }
}
