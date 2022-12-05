<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_dokter' => 'DR-0000001',
                'id_user' => 2,
                'nip' => '196909141990031002',
                'nama' => 'dr. Nadia',
                'telepon' => '08123456789',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1990-12-12',
                'jenis_kelamin' => 'Perempuan',
                'tipe_dokter' => 'Umum',
                'pengalaman_praktik' => 'RSUD Bandung',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id_dokter' => 'DR-0000002',
                'id_user' => 3,
                'nip' => '196909141990031001',
                'nama' => 'dr. emirianti',
                'telepon' => '08123456789',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1990-12-12',
                'jenis_kelamin' => 'Perempuan',
                'tipe_dokter' => 'Umum',
                'pengalaman_praktik' => 'RSUD Bandung',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id_dokter' => 'DR-0000003',
                'id_user' => 4,
                'nip' => '196909141990031004',
                'nama' => 'drg. Chandra',
                'telepon' => '08123456789',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1990-12-12',
                'jenis_kelamin' => 'Laki-laki',
                'tipe_dokter' => 'Gigi',
                'pengalaman_praktik' => 'RSUD Bandung',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('tb_dokter')->insertBatch($data);
    }
}
