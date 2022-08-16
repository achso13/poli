<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_pasien' => 'PSN-000001',
            'id_user' => 3,
            'id_unitkerja' => 1,
            'nip' => '1810512094123456',
            'nama' => 'Achmad',
            'alamat_rumah' => 'Jl. Raya',
            'telepon' => '08123456789',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-12-12',
            'jenis_kelamin' => 'Laki-laki'
        ];

        $this->db->table('tb_pasien')->insert($data);
    }
}
