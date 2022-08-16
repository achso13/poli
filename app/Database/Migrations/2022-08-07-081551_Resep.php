<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Resep extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_resep' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true,
                'unsigned' => true,
                'unique' => true
            ],
            'id_rekam_medis' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'resep_dokter' => [
                'type' => 'text',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => '"Belum Selesai","Sedang Disiapkan","Sudah Selesai"',
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

        $this->forge->addKey('id_resep', true);
        $this->forge->addForeignKey('id_rekam_medis', 'tb_rekam_medis', 'id_rekam_medis', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_resep');
    }

    public function down()
    {
        $this->forge->dropTable('tb_resep');
    }
}
