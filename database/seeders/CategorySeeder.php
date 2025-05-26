<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('categories')->insert([
        [
            'category_name' => 'Action',
            'description' => 'Film dengan adegan-adegan penuh aksi dan ketegangan.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_name' => 'Comedy',
            'description' => 'Film yang bertujuan untuk menghibur dan mengundang tawa.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_name' => 'Drama',
            'description' => 'Film yang berfokus pada pengembangan karakter dan konflik emosional.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_name' => 'Sci-Fi',
            'description' => 'Film dengan latar belakang ilmiah dan teknologi futuristik.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'category_name' => 'Romance',
            'description' => 'Film yang berpusat pada kisah cinta dan hubungan romantis.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}
