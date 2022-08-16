<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_dokter' => 'DR-0000001',
            'id_user' => 2,
            'nip' => '1810512094123456',
            'nama' => 'dr. Achmad',
            'telepon' => '08123456789',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-12-12',
            'jenis_kelamin' => 'Laki-laki',
            'tipe_dokter' => 'Umum',
        ];
        $this->db->table('tb_dokter')->insert($data);
    }
}
