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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => null,
                'role' => 'DOKTER',
                'nama' => 'dr. Nadia',
                'username' => 'nadia',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'nadia@gmail.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => null,
                'role' => 'DOKTER',
                'nama' => 'dr. emirianti',
                'username' => 'emirianti',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'emirianti@gmail.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => null,
                'role' => 'DOKTER',
                'nama' => 'drg. Chandra',
                'username' => 'chandra',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'chandra@gmail.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => null,
                'role' => 'PASIEN',
                'nama' => 'Achmad',
                'username' => '199001012020010101',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'pasien@email.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => 1,
                'role' => 'KLINIK',
                'nama' => 'Laboratorium',
                'username' => 'lab',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'lab1@email.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => 2,
                'role' => 'KLINIK',
                'nama' => 'Fisioterapi',
                'username' => 'fisioterapi',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'fisioterapi1@email.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => 3,
                'role' => 'KLINIK',
                'nama' => 'Akupuntur',
                'username' => 'akupuntur',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'akupuntur1@email.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_klinik' => null,
                'role' => 'APOTEKER',
                'nama' => 'Apoteker',
                'username' => 'apoteker',
                'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
                'email' => 'apoteker@email.com',
                'photo' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('tb_user')->insertBatch($data);
    }
}
