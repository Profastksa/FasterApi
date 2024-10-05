<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::insert([
            [
                'name' => 'الخرطوم',
                'fees' => '400',
            ],
            [
                'name' => 'امدرمان',
                'fees' => '600',
            ],
        ]);
    }
}
