<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'id_treatment' => 'TRT-000001',
                'id_klinik' => 1,
                'nama_treatment' => 'Swab Antigen',
                'deskripsi' => 'Swab antigen untuk mengetahui tipe antigen',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_treatment' => 'TRT-000002',
                'id_klinik' => 1,
                'nama_treatment' => 'Swab PCR',
                'deskripsi' => 'Swab PCR untuk mengetahui tipe antigen',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_treatment' => 'TRT-000003',
                'id_klinik' => 2,
                'nama_treatment' => 'Fisioterapi',
                'deskripsi' => 'Fisioterapi',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_treatment' => 'TRT-000004',
                'id_klinik' => 3,
                'nama_treatment' => 'Akupuntur',
                'deskripsi' => 'Akupuntur',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('tb_treatment')->insertBatch($data);
    }
}
