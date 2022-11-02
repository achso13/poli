<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pesan' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true,
                'unsigned' => true,
                'unique' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'id_kunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
            ],
            'pesan' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_pesan', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kunjungan', 'tb_kunjungan', 'id_kunjungan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_pesan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pesan');
    }
}
