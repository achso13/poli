<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Klinik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_klinik'          => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => true,
                'unsigned'       => true,
                'unique'        => true
            ],
            'nama_klinik'      => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addKey('id_klinik', true);
        $this->forge->createTable('tb_klinik');
    }

    public function down()
    {
        $this->forge->dropTable('tb_klinik');
    }
}
