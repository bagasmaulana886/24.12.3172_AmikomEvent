<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'name' => 'Tech Innovation Indonesia',
            'logo_url' => 'https://placehold.co/200x200?text=Tech+Innovation',
        ]);

        Partner::create([
            'name' => 'Digital Solutions Asia',
            'logo_url' => 'https://placehold.co/200x200?text=Digital+Solutions',
        ]);

        Partner::create([
            'name' => 'Amikom Yogyakarta',
            'logo_url' => 'https://placehold.co/200x200?text=Amikom',
        ]);

        Partner::create([
            'name' => 'Creative Agency Studio',
            'logo_url' => 'https://placehold.co/200x200?text=Creative+Agency',
        ]);

        Partner::create([
            'name' => 'Cloud Computing Services',
            'logo_url' => 'https://placehold.co/200x200?text=Cloud+Services',
        ]);
    }
}
