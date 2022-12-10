<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'id_user' => 1,
                'judul' => 'Pengumuman 1',
                'isi' => 'Ini adalah pengumuman 1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 1,
                'judul' => 'Pengumuman 2',
                'isi' => 'Ini adalah pengumuman 2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 1,
                'judul' => 'Pengumuman 3',
                'isi' => 'Ini adalah pengumuman 3',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('tb_pengumuman')->insertBatch($data);
    }
}
