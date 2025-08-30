<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// Order matters: customers first because DeviceRepair depends on customers
		$this->call([
			CustomersSeeder::class,
			DeviceRepairSeeder::class,
			AdminUserSeeder::class,
			UserSeeder::class,
		]);
	}
}

