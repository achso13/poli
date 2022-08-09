<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Biro extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_biro'          => [
				'type'           => 'INT',
				'constraint'	 => '11',
				'auto_increment' => true,
				'unsigned'       => true,
				'unique'		=> true
			],
			'nama_biro'      => [
				'type'       => 'VARCHAR',
				'constraint' => '100',
			],
			'created_at' => [
				'type'	=> 'datetime',
				'null'	=> true
			],
			'updated_at' => [
				'type'	=> 'datetime',
				'null'	=> true
			],
		]);
		$this->forge->addKey('id_biro', true);
		$this->forge->createTable('tb_biro');
	}

	public function down()
	{
		$this->forge->dropTable('tb_biro');
	}
}
