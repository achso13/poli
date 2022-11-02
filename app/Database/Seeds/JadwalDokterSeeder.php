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
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Selasa',
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Rabu',
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Kamis',
            ],
            [
                'id_dokter' => 'DR-0000001',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:30:00',
                'hari' => 'Jumat',
            ],
        ];

        $this->db->table('tb_jadwal_dokter')->insertBatch($data);
    }
}
