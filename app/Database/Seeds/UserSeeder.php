<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_klinik' => null,
                'role' => 'ADMIN',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'admin@email.com',
                'photo' => null,
            ],
            [
                'id_klinik' => null,
                'role' => 'DOKTER',
                'nama' => 'dr. Achmad',
                'username' => 'dokter',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'achsozou@gmail.com',
                'photo' => null,
            ],
            [
                'id_klinik' => null,
                'role' => 'PASIEN',
                'nama' => 'Achmad',
                'username' => '1810512094123456',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'pasien@email.com',
                'photo' => null,
            ],
            [
                'id_klinik' => 1,
                'role' => 'KLINIK',
                'nama' => 'Klinik 1',
                'username' => 'klinik1',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'klinik1@email.com',
                'photo' => null,
            ],
            [
                'id_klinik' => null,
                'role' => 'APOTEKER',
                'nama' => 'Apoteker',
                'username' => 'apoteker',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'apoteker@email.com',
                'photo' => null,
            ]
        ];
        $this->db->table('tb_user')->insertBatch($data);
    }
}
