<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KlinikSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            ['nama_klinik' => "Laboratorium"],
            ['nama_klinik' => "Fisioterapi"],
            ['nama_klinik' => "Akupuntur"]
        ];

        $this->db->table('tb_klinik')->insertBatch($data);
    }
}
