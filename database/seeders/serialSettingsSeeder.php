<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class serialSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('serial_settings')->insert([
            [
                'inv_no' => 0,
                'trans_no' => 0,
            ],
        ]);
    }
}
