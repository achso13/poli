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
                'constraint' => '14',
            ],
            'diagnosa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'anamnesa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jadwal_treatment' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'hasil_treatment' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'berat_badan' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
                'null' => true,
            ],
            'tinggi_badan' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
                'null' => true,
            ],
            'alergi_obat' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
