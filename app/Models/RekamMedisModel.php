<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table            = 'tb_rekam_medis';
    protected $primaryKey       = 'id_rekam_medis';
    protected $allowedFields    = [
        'id_dokter',
        'id_pasien',
        'id_treatment',
        'id_kunjungan',
        'diagnosa',
        'anamnesa',
        'tindakan',
        'jadwal_treatment',
        'hasil_treatment',
        'berat_badan',
        'tinggi_badan',
        'alergi_obat',
        'keterangan'
    ];

    protected $useTimestamps    = true;

    public function getRekamMedisByPatient($id)
    {
        // join table tb_pasien, tb_dokter, tb_kunjungan
        $builder = $this->db->table($this->table);
        $builder->select('tb_rekam_medis.*, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter, tb_kunjungan.tanggal_kunjungan, tb_kunjungan.keluhan, tb_resep.resep_dokter, tb_treatment.nama_treatment');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_rekam_medis.id_pasien');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_rekam_medis.id_dokter');
        $builder->join('tb_kunjungan', 'tb_kunjungan.id_kunjungan = tb_rekam_medis.id_kunjungan');
        $builder->join('tb_resep', 'tb_resep.id_rekam_medis = tb_rekam_medis.id_rekam_medis');
        $builder->join('tb_treatment', 'tb_treatment.id_treatment = tb_rekam_medis.id_treatment');
        $builder->where('tb_rekam_medis.id_pasien', $id);
        $builder->where('tb_kunjungan.tipe_kunjungan', 'Offline');
        $builder->orderBy('id_rekam_medis', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getRekamMedisByKunjungan($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_rekam_medis.*, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter, tb_kunjungan.tanggal_kunjungan, tb_kunjungan.keluhan, tb_resep.resep_dokter');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_rekam_medis.id_pasien');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_rekam_medis.id_dokter');
        $builder->join('tb_kunjungan', 'tb_kunjungan.id_kunjungan = tb_rekam_medis.id_kunjungan');
        $builder->join('tb_resep', 'tb_resep.id_rekam_medis = tb_rekam_medis.id_rekam_medis');
        $builder->where('tb_rekam_medis.id_kunjungan', $id);
        $builder->where('tb_kunjungan.tipe_kunjungan', 'Offline');
        $builder->orderBy('id_rekam_medis', 'DESC');
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getTreatmentSchedule($id = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_rekam_medis.*, tb_pasien.nama as nama_pasien, tb_dokter.nama as nama_dokter, tb_treatment.id_treatment, tb_treatment.nama_treatment, tb_resep.resep_dokter');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_rekam_medis.id_pasien', 'left');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_rekam_medis.id_dokter', 'left');
        $builder->join('tb_treatment', 'tb_treatment.id_treatment = tb_rekam_medis.id_treatment', 'left');
        $builder->join('tb_resep', 'tb_resep.id_rekam_medis = tb_rekam_medis.id_rekam_medis', 'left');

        if (session()->get('log_role') === "KLINIK") {
            $idKlinik = $this->db->table('tb_user')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_klinik'];
            $builder->where('tb_treatment.id_klinik', $idKlinik);
        }

        if (session()->get('log_role') === "PASIEN") {
            $idPasien = $this->db->table('tb_pasien')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_pasien'];
            $builder->where('tb_rekam_medis.id_pasien', $idPasien);
        }

        if ($id != NULL) {
            $builder->where('tb_rekam_medis.id_rekam_medis', $id);
            return $builder->get()->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }
}
