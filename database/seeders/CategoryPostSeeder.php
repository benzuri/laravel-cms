<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Avengers',
                'slug' => 'avengers',
            ],
            [
                'name' => 'Guardians of the galaxy',
                'slug' => 'guardians-of-the-galaxy',
            ],
        ];

        DB::table('category_posts')->insert($categories);
    }
}
