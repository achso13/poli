<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => true,
                'unsigned'       => true,
                'unique'        => true
            ],
            'id_klinik' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'      => true,
                'null'           => true,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => '"ADMIN", "PASIEN", "KLINIK", "APOTEKER", "DOKTER"',
                'default' => 'PASIEN',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'datetime',
                'null'    => true
            ],
            'updated_at' => [
                'type'    => 'datetime',
                'null'    => true
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->addForeignKey('id_klinik', 'tb_klinik', 'id_klinik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_user');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_user');
    }
}
