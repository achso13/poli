<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BiroSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'nama_biro' => 'Sekretaris Jenderal',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Inspektorat',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Deputi Bidang Administrasi',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Deputi Bidang Persidangan',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Organisasi, Keanggotaan dan Kepegawaian',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Perencanaan dan Keuangan',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Sistem Informasi dan Dokumentasi',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Umum',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Protokol, Hubungan Masyarakat dan Media',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Persidangan I',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Persidangan II',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Biro Sekretariat Pimpinan',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Pusat Perancangan dan Kajian Kebijakan Hukum',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'nama_biro' => 'Pusat Kajian Daerah dan Anggaran',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
		];

		// Using Query Builder
		$this->db->table('tb_biro')->insertBatch($data);
	}
}
