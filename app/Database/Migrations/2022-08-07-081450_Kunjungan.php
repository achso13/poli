<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kunjungan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
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
            'id_jadwal_dokter' => [
                'type' => 'int',
                'constraint' => '11',
                'unsigned' => true,
                'null' => true,
            ],
            'tanggal_kunjungan' => [
                'type' => 'DATE',
            ],
            'keluhan' => [
                'type' => 'varchar',
                'constraint' => '70',
            ],
            'tipe_kunjungan' => [
                'type' => 'ENUM',
                'constraint' => '"Offline","Online"',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => '"Aktif", "Selesai"',
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
        $this->forge->addKey('id_kunjungan', true);
        $this->forge->addForeignKey('id_pasien', 'tb_pasien', 'id_pasien', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_dokter', 'tb_dokter', 'id_dokter', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jadwal_dokter', 'tb_jadwal_dokter', 'id_jadwal_dokter', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_kunjungan');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_kunjungan');
    }
}
