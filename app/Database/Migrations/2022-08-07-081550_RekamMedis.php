<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RekamMedis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rekam_medis' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true,
                'unsigned' => true,
                'unique' => true
            ],
            'id_pasien' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'id_dokter' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'id_treatment' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null' => true,
            ],
            'id_kunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'diagnosa' => [
                'type' => 'text',
            ],
            'anamnesa' => [
                'type' => 'text',
            ],
            'tindakan' => [
                'type' => 'text',
            ],
            'resep_dokter' => [
                'type' => 'text',
            ],
            'jadwal_treatment' => [
                'type' => 'datetime',
                'null' => true,
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
        $this->forge->addKey('id_rekam_medis', true);
        $this->forge->addForeignKey('id_pasien', 'tb_pasien', 'id_pasien', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dokter', 'tb_dokter', 'id_dokter', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_treatment', 'tb_treatment', 'id_treatment', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kunjungan', 'tb_kunjungan', 'id_kunjungan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_rekam_medis');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_rekam_medis');
    }
}
