<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('websites')->insert([
            [
                'site_name' => 'Example Site 1',
                'site_url'  => 'https://example1.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Example Site 2',
                'site_url'  => 'https://example2.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'site_name' => 'Example Site 3',
                'site_url'  => 'https://example3.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
