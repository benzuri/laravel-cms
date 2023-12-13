<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = 'settings';
        $items = [
            [
                'user_id' => 1,
                'key' => 'app_name',
                'value' => 'Simple CMS',
            ],
            [
                'user_id' => 1,
                'key' => 'pagination',
                'value' => 8,
            ],
        ];

        DB::table($table)->insert($items);
    }
}
