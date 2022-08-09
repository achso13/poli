<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pasien' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'unique'        => true
            ],
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
            ],
            'id_unitkerja' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
            ],
            'nip' => [
                'type'           => 'VARCHAR',
                'constraint'     => '18',
                'null'          => true,
            ],
            'nama' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'          => true,
            ],
            'alamat_rumah' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'          => true,
            ],
            'telepon' => [
                'type'           => 'VARCHAR',
                'constraint'     => '15',
                'null'          => true,
            ],
            'jenis_kelamin' => [
                'type'           => 'ENUM',
                'constraint'     => '"Laki-laki","Perempuan"',
                'null'          => true,
            ],
            'tanggal_lahir' => [
                'type'           => 'DATE',
                'null'          => true,
            ],
            'tempat_lahir' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'          => true,
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
        $this->forge->addKey('id_pasien', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_unitkerja', 'tb_unitkerja', 'id_unitkerja', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_pasien');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_pasien');
    }
}
