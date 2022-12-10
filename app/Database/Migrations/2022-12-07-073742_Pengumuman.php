<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengumuman extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_pengumuman' => [
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
            'judul' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'isi' => [
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

        $this->forge->addKey('id_pengumuman', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_pengumuman');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_pengumuman');
    }
}
