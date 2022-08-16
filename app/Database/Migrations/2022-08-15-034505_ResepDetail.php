<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResepDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_resep_detail' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true,
                'unsigned' => true,
                'unique' => true
            ],
            'id_resep' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'id_obat' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'keterangan' => [
                'type' => 'text',
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
        $this->forge->addKey('id_resep_detail', true);
        $this->forge->addForeignKey('id_resep', 'tb_resep', 'id_resep', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_obat', 'tb_obat', 'id_obat', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_resep_detail');
    }

    public function down()
    {
        $this->forge->dropTable('tb_resep_detail');
    }
}
