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
		// Urutan seeder: data master dulu, lalu relasi
		$this->call([
			AboutSectionSeeder::class,
			AdminUserSeeder::class,
			AdvantageSectionSeeder::class,
			AdvantageSeeder::class,
			CmsSectionSeeder::class,
			ContactInfoSeeder::class,
			ContactSectionSeeder::class,
			CtaSectionSeeder::class,
			CustomersSeeder::class,
			DeviceRepairSeeder::class,
			HeroSectionSeeder::class,
			IndoRegionSeeder::class,
			PromoSectionSeeder::class,
			PromoSeeder::class,
			ServiceSectionSeeder::class,
			StepSectionSeeder::class,
			StepSeeder::class,
			TestimonialSeeder::class,
			VideoSectionSeeder::class,
			UserSeeder::class,
		]);
	}
}

