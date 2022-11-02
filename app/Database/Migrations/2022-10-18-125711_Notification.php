<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'pesan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_read' => [
                'type' => 'INT',
                'constraint' => '1',
                'default' => 0,
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_notification');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_notification');
    }
}
