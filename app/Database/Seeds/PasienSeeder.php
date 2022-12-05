<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_pasien' => 'PSN-000001',
            'id_user' => 5,
            'id_unitkerja' => 1,
            'nip' => '199001012020010101',
            'nama' => 'Achmad',
            'alamat_rumah' => 'Jl. Raya',
            'telepon' => '08123456789',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-12-12',
            'jenis_kelamin' => 'Laki-laki',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('tb_pasien')->insert($data);
    }
}
