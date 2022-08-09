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
			],
			[
				'nama_biro' => 'Inspektorat',
			],
			[
				'nama_biro' => 'Deputi Bidang Administrasi',
			],
			[
				'nama_biro' => 'Deputi Bidang Persidangan',
			],
			[
				'nama_biro' => 'Biro Organisasi, Keanggotaan dan Kepegawaian',
			],
			[
				'nama_biro' => 'Biro Perencanaan dan Keuangan',
			],
			[
				'nama_biro' => 'Biro Sistem Informasi dan Dokumentasi',
			],
			[
				'nama_biro' => 'Biro Umum',
			],
			[
				'nama_biro' => 'Biro Protokol, Hubungan Masyarakat dan Media',
			],
			[
				'nama_biro' => 'Biro Persidangan I',
			],
			[
				'nama_biro' => 'Biro Persidangan II',
			],
			[
				'nama_biro' => 'Biro Sekretariat Pimpinan',
			],
			[
				'nama_biro' => 'Pusat Perancangan dan Kajian Kebijakan Hukum',
			],
			[
				'nama_biro' => 'Pusat Kajian Daerah dan Anggaran',
			],
		];

		// Using Query Builder
		$this->db->table('tb_biro')->insertBatch($data);
	}
}
