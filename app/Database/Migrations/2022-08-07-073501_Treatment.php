<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Treatment extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_treatment'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'unique'        => true
            ],
            'id_klinik' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
            ],
            'nama_treatment' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'deskripsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jam_buka'  =>  [
                'type' => 'TIME',
            ],
            'jam_tutup' =>  [
                'type' => 'TIME',
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
        $this->forge->addKey('id_treatment', true);
        $this->forge->addForeignKey('id_klinik', 'tb_klinik', 'id_klinik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_treatment');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_treatment');
    }
}
