<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PartnerSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        // 2. Insert Kategori Event (3+ categories)
        $categoryIT = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $categoryEntertainment = Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        $categorySports = Category::create([
            'name' => 'Olahraga & Kompetisi',
            'slug' => 'olahraga-kompetisi',
        ]);

        // 3. Insert Sampel Events (6+ varied events)
        Event::create([
            'category_id' => $categoryEntertainment->id,
            'title' => 'Jazz Night 2026',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz klasik dari musisi profesional.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru - Aula Utama',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        Event::create([
            'category_id' => $categoryIT->id,
            'title' => 'AI Summit & Expo 2026',
            'description' => 'Jelajahi tren terkini dalam bidang Artificial Intelligence dan Machine Learning bersama para ahli industri.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Ruang Cinema - Kampus Utama',
            'price' => 45000,
            'stock' => 150,
            'poster_path' => 'posters/event-2.png',
        ]);

        Event::create([
            'category_id' => $categoryIT->id,
            'title' => 'Web Development Masterclass',
            'description' => 'Pelajari teknik-teknik terbaru dalam pengembangan web dengan framework modern seperti Laravel dan React.',
            'date' => '2026-05-15 10:00:00',
            'location' => 'Lab Komputer Jl. Ring Road',
            'price' => 35000,
            'stock' => 80,
            'poster_path' => 'posters/event-3.png',
        ]);

        Event::create([
            'category_id' => $categorySports->id,
            'title' => 'E-Sports Championship 2026',
            'description' => 'Turnamen gaming terbesar dengan berbagai kategori permainan. Hadiah total ratusan juta rupiah.',
            'date' => '2026-05-20 16:00:00',
            'location' => 'Gedung Olahraga - Amikom',
            'price' => 25000,
            'stock' => 200,
            'poster_path' => 'posters/event-4.png',
        ]);

        Event::create([
            'category_id' => $categoryEntertainment->id,
            'title' => 'Stand-up Comedy Night',
            'description' => 'Malam yang penuh tawa dengan komikus-komikus terbaik Indonesia. Jangan lewatkan kesempatan ini!',
            'date' => '2026-05-25 20:30:00',
            'location' => 'Aula Serbaguna - Downtown',
            'price' => 75000,
            'stock' => 120,
            'poster_path' => 'posters/event-5.png',
        ]);

        Event::create([
            'category_id' => $categoryIT->id,
            'title' => 'UI/UX Design Workshop',
            'description' => 'Workshop intensif tentang prinsip-prinsip desain user interface dan user experience yang baik.',
            'date' => '2026-06-05 14:00:00',
            'location' => 'Studio Desain - Gedung Kreatif',
            'price' => 40000,
            'stock' => 60,
            'poster_path' => 'posters/event-6.png',
        ]);

        Event::create([
            'category_id' => $categorySports->id,
            'title' => 'Futsal Tournament Pro',
            'description' => 'Turnamen futsal antar kampus dengan standar internasional. Peserta akan berkompetisi untuk gelar juara.',
            'date' => '2026-06-10 17:00:00',
            'location' => 'Lapangan Futsal Modern - Sports Center',
            'price' => 15000,
            'stock' => 250,
            'poster_path' => 'posters/event-7.png',
        ]);

        // 4. Seed Partner Data
        $this->call(PartnerSeeder::class);
    }
}
