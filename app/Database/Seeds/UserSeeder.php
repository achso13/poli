<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_klinik' => null,
            'role' => 'ADMIN',
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => '$2y$10$5GGRjcKHaBJSmIhKI65pzOO7zup.tL0zd1uzRV1gvVxEppO5h6GSm',
            'email' => 'admin@email.com',
            'photo' => null,
        ];
        $this->db->table('tb_user')->insert($data);
    }
}
