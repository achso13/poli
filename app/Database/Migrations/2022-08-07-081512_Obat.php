<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Obat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_obat' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'unique' => true,
            ],
            'nama_obat' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
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
        $this->forge->addKey('id_obat', true);
        $this->forge->createTable('tb_obat');
    }

    public function down()
    {
        $this->forge->dropTable('tb_obat');
    }
}
