<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalDokter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal_dokter' => [
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true,
                'unsigned' => true,
                'unique' => true
            ],
            'id_dokter' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_jadwal_dokter', true);
        $this->forge->addForeignKey('id_dokter', 'tb_dokter', 'id_dokter', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_jadwal_dokter');
    }

    public function down()
    {
        $this->forge->dropTable('tb_jadwal_dokter');
    }
}
