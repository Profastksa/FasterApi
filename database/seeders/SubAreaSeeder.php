<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubArea;

class SubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubArea::insert([
            [
                'name' => 'اركويت',
                'area_id' => 1,
            ],
            [
                'name' => 'الرياض',
                'area_id' => 1,
            ],
            [
                'name' => 'بيت المال',
                'area_id' => 2,
            ],
            [
                'name' => 'الثوره',
                'area_id' => 2,
            ],
            [
                'name' => 'الطائف',
                'area_id' => 1,
            ],
            [
                'name' => 'جبره',
                'area_id' => 1,
            ],
        ]);
    }
}
