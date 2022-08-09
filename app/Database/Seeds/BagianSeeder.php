<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BagianSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'nama_bagian' 	=> 'Sekretaris Jenderal',
				'id_biro'		=> 1,
			],
			[
				'nama_bagian' 	=> 'Inspektorat',
				'id_biro'		=> 2,
			],
			[
				'nama_bagian' 	=> 'Deputi Bidang Administrasi',
				'id_biro'		=> 3,
			],
			[
				'nama_bagian' 	=> 'Deputi Bidang Persidangan',
				'id_biro'		=> 4,
			],
			[
				'nama_bagian' 	=> 'Bagian Organisasi dan Ketatalaksanaan',
				'id_biro'		=> 5,
			],
			[
				'nama_bagian' 	=> 'Bagian Administrasi Keanggotaan dan Kepegawaian',
				'id_biro'		=> 5,
			],
			[
				'nama_bagian' 	=> 'Bagian Pengembangan Sumber Daya Manusia',
				'id_biro'		=> 5,
			],
			[
				'nama_bagian' 	=> 'Bagian Hukum',
				'id_biro'		=> 5,
			],
			[
				'nama_bagian' 	=> 'Bagian Perencanaan',
				'id_biro'		=> 6,
			],
			[
				'nama_bagian' 	=> 'Bagian Administrasi, Gaji, Tunjangan dan Honorarium',
				'id_biro'		=> 6,
			],
			[
				'nama_bagian' 	=> 'Bagian Pembendaharaan',
				'id_biro'		=> 6,
			],
			[
				'nama_bagian' 	=> 'Bagian Akuntansi dan Pelaporan',
				'id_biro'		=> 6,
			],
			[
				'nama_bagian' 	=> 'Bagian Pengelolaan Sistem Informasi',
				'id_biro'		=> 7,
			],
			[
				'nama_bagian' 	=> 'Bagian Risalah',
				'id_biro'		=> 7,
			],
			[
				'nama_bagian' 	=> 'Bagian Kearsipan, Perpustakaan, dan Penerbitan',
				'id_biro'		=> 7,
			],
			[
				'nama_bagian' 	=> 'Bagian Pengelolaan Barang Milik Negara',
				'id_biro'		=> 8,
			],
			[
				'nama_bagian' 	=> 'Bagian Pemeliharaan dan Perlengkapan',
				'id_biro'		=> 8,
			],
			[
				'nama_bagian' 	=> 'Bagian Layanan Pengadaan',
				'id_biro'		=> 8,
			],
			[
				'nama_bagian' 	=> 'Bagian Pengamanan Dalam',
				'id_biro'		=> 8,
			],
			[
				'nama_bagian' 	=> 'Bagian Protokol',
				'id_biro'		=> 9,
			],
			[
				'nama_bagian' 	=> 'Bagian Hubungan Masyarakat dan Fasilitasi Pengaduan',
				'id_biro'		=> 9,
			],
			[
				'nama_bagian' 	=> 'Bagian Pemberitaan dan Media',
				'id_biro'		=> 9,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Komite I',
				'id_biro'		=> 10,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Komite III',
				'id_biro'		=> 10,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Panitia Perancang Undang-Undang',
				'id_biro'		=> 10,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat BPKK/Kelompok DPD RI di MPR RI',
				'id_biro'		=> 10,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Badan Kerja Sama Parlemen',
				'id_biro'		=> 10,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Komite II',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Komite IV',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Persidangan Paripurna Panmus Pangus',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Badan Kehormatan',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Panitia Urusan Rumah Tangga',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Badan Akuntabilitas Publik',
				'id_biro'		=> 11,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Ketua DPD RI',
				'id_biro'		=> 12,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Wakil Ketua DPD RI Bidang I',
				'id_biro'		=> 12,
			],
			[
				'nama_bagian' 	=> 'Bagian Sekretariat Wakil Ketua DPD RI Bidang II',
				'id_biro'		=> 12,
			],
			[
				'nama_bagian' 	=> 'Bagian Tata Usaha Pimpinan Sekretariat Jenderal',
				'id_biro'		=> 12,
			],
			[
				'nama_bagian' 	=> 'Bidang Perancangan dan Pemantauan Peraturan Perundang-Undangan',
				'id_biro'		=> 13,
			],
			[
				'nama_bagian' 	=> 'Bidang Dokumentasi Jaringan Informasi Hukum Pusat dan Daerah',
				'id_biro'		=> 13,
			],
			[
				'nama_bagian' 	=> 'Bidang Diseminasi Aspirasi Masyarakat dan Daerah',
				'id_biro'		=> 14,
			],
			[
				'nama_bagian' 	=> 'Bidang Pengkajian dan Informasi Anggaran Pusat dan Daerah',
				'id_biro'		=> 14,
			],
		];

		// Using Query Builder
		$this->db->table('tb_unitkerja')->insertBatch($data);
	}
}
