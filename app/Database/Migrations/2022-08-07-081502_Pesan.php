<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pesan' => [
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
            'id_pasien' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'id_kunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'pesan' => [
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
        $this->forge->addKey('id_pesan', true);
        $this->forge->addForeignKey('id_dokter', 'tb_dokter', 'id_dokter', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pasien', 'tb_pasien', 'id_pasien', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kunjungan', 'tb_kunjungan', 'id_kunjungan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_pesan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pesan');
    }
}
