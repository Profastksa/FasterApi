<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            [
                "key" => "order_return_price",
                "value" => "300"
            ],
            [
                "key" => "representative_deserves_calculation_method",
                "value" => "percentage" //orders_per_day - percentage
            ],
            [
                "key" => "representative_percentage",
                "value" => "50"
            ],
            [
                "key" => "exceeding_order_ranges_bounce",
                "value" => "100"
            ],
            [
                "key" => 'tax_precntage',
                'value' => 10,
            ]
        ]);
    }
}
