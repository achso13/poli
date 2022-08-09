<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BatchSeeder extends Seeder
{
	public function run()
	{
		$this->call('BiroSeeder');
		$this->call('BagianSeeder');
		$this->call('UserSeeder');
	}
}
