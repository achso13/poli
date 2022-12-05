<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KlinikSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'nama_klinik' => "Laboratorium",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_klinik' => "Fisioterapi",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_klinik' => "Akupuntur",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('tb_klinik')->insertBatch($data);
    }
}
