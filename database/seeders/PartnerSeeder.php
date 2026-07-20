<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate minimal 5 partner data dengan Faker
        for ($i = 1; $i <= 5; $i++) {
            Partner::create([
                'name' => $faker->company(),
                'logo_url' => 'https://placehold.co/200x200?text=' . urlencode('Partner ' . $i),
            ]);
        }
    }
}
