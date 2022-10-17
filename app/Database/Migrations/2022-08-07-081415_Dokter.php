<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dokter extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_dokter' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'unique' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => '18',
                'null' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '70',
                'null' => true
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => '"Laki-laki","Perempuan"',
                'null' => true
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true
            ],
            'tipe_dokter' => [
                'type' => 'ENUM',
                'constraint' => '"Gigi","Umum"',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id_dokter', true);
        $this->forge->createTable('tb_dokter');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_dokter');
    }
}
