<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Senin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Selasa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Rabu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Kamis',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Jumat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000002',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Senin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000002',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Selasa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000002',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Rabu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000002',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Kamis',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000002',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Jumat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000003',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Senin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000003',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Selasa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000003',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Rabu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000003',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Kamis',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_dokter' => 'DR-0000003',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Jumat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_jadwal_dokter')->insertBatch($data);
    }
}
