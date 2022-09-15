<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table            = 'tb_kunjungan';
    protected $primaryKey       = 'id_kunjungan';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'id_kunjungan',
        'id_dokter',
        'id_pasien',
        'id_jadwal_dokter',
        'tanggal_kunjungan',
        'keluhan',
        'tipe_kunjungan',
        'status',
    ];

    protected $useTimestamps = true;

    public function getAppointments($id = null, $type = NULL, $date = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_kunjungan.*, tb_dokter.nama as nama_dokter, tb_pasien.nama as nama_pasien, tb_pasien.jenis_kelamin, tb_pasien.tanggal_lahir, tb_unitkerja.nama_bagian, tb_biro.nama_biro, tb_jadwal_dokter.jam_mulai, tb_jadwal_dokter.jam_selesai');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_kunjungan.id_dokter', 'left');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_kunjungan.id_pasien', 'left');
        $builder->join('tb_jadwal_dokter', 'tb_jadwal_dokter.id_jadwal_dokter = tb_kunjungan.id_jadwal_dokter', 'left');
        $builder->join('tb_unitkerja', 'tb_unitkerja.id_unitkerja = tb_pasien.id_unitkerja', 'left');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');
        $builder->orderBy('tb_kunjungan.tanggal_kunjungan', 'DESC');

        if (session()->get('log_role') == 'PASIEN') {
            // look for id pasien in database
            $idPasien = $this->db->table('tb_pasien')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_pasien'];
            if (isset($idPasien)) {
                $builder->where('tb_kunjungan.id_pasien', $idPasien);
            }
        }

        if (session()->get('log_role') == "DOKTER") {
            $idDokter = $this->db->table('tb_dokter')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_dokter'];
            if (isset($idDokter)) {
                $builder->where('tb_kunjungan.id_dokter', $idDokter);
            }
        }

        if ($type !== null) {
            $builder->where('tb_kunjungan.tipe_kunjungan', $type);
        }

        if ($date !== null) {
            $tanggalAwal = $date[0];
            $tanggalAkhir = $date[1];

            $builder->where("tb_kunjungan.tanggal_kunjungan >=", $tanggalAwal);
            $builder->where("tb_kunjungan.tanggal_kunjungan <=", $tanggalAkhir);
        }

        if ($id !== null) {
            $builder->where('tb_kunjungan.id_kunjungan', $id);
            $query = $builder->get();
            return $query->getRowArray();
        } else {
            $query = $builder->get();
            return $query->getResultArray();
        }
    }

    public function getAppointmentCount($type = NULL)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tb_kunjungan.*, tb_dokter.nama as nama_dokter, tb_pasien.nama as nama_pasien, tb_pasien.jenis_kelamin, tb_pasien.tanggal_lahir, tb_unitkerja.nama_bagian, tb_biro.nama_biro, tb_jadwal_dokter.jam_mulai, tb_jadwal_dokter.jam_selesai');
        $builder->join('tb_dokter', 'tb_dokter.id_dokter = tb_kunjungan.id_dokter', 'left');
        $builder->join('tb_pasien', 'tb_pasien.id_pasien = tb_kunjungan.id_pasien', 'left');
        $builder->join('tb_jadwal_dokter', 'tb_jadwal_dokter.id_jadwal_dokter = tb_kunjungan.id_jadwal_dokter', 'left');
        $builder->join('tb_unitkerja', 'tb_unitkerja.id_unitkerja = tb_pasien.id_unitkerja', 'left');
        $builder->join('tb_biro', 'tb_biro.id_biro = tb_unitkerja.id_biro', 'left');
        $builder->orderBy('tb_kunjungan.tanggal_kunjungan', 'DESC');

        if (session()->get('log_role') == 'PASIEN') {
            // look for id pasien in database
            $idPasien = $this->db->table('tb_pasien')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_pasien'];
            if (isset($idPasien)) {
                $builder->where('tb_kunjungan.id_pasien', $idPasien);
            }
        }

        if (session()->get('log_role') == "DOKTER") {
            $idDokter = $this->db->table('tb_dokter')->where('id_user', session()->get('log_id'))->get()->getRowArray()['id_dokter'];
            if (isset($idDokter)) {
                $builder->where('tb_kunjungan.id_dokter', $idDokter);
            }
        }

        if ($type !== null) {
            $builder->where('tb_kunjungan.tipe_kunjungan', $type);
        }

        return $builder->countAllResults();
    }
}
