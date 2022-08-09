<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitKerja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_unitkerja'          => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned' => true,
                'auto_increment' => true,
                'unique'         => true,
            ],
            'nama_bagian'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_biro'          => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
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
        $this->forge->addKey('id_unitkerja', true);
        $this->forge->addForeignKey('id_biro', 'tb_biro', 'id_biro', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_unitkerja');
    }

    public function down()
    {
        $this->forge->dropTable('tb_unitkerja');
    }
}
