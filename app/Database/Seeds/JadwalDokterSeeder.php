<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalDokterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_dokter' => 'DR-0000001
',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'keterangan' => 'Senin - Jumat',
            ],
            [
                'id_dokter' => 'DR-0000001
',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:30:00',
                'keterangan' => 'Senin - Jumat',
            ],
        ];

        $this->db->table('tb_jadwal_dokter')->insertBatch($data);
    }
}
