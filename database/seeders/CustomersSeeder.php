<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterData\Customers;
use Faker\Factory as Faker;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // If customers table already has data, skip seeding
        if (Customers::count() > 0) {
            $this->command->info('Customers table already seeded. Skipping.');
            return;
        }

        $faker = Faker::create('id_ID'); // Indonesian locale
        
        // Generate 50 random customers
        for ($i = 1; $i <= 50; $i++) {
            Customers::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'status' => $faker->boolean(80), // 80% chance to be active
            ]);
        }
    }
}
