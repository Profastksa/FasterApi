<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select(
            "INSERT INTO `ahmedict_faster1`.`orders` (`tracking_number`, `service_id`, `client_id`, `representative_id`, `sender_name`, `sender_phone`, `sender_area_id`, `sender_sub_area_id`, `sender_address`, `receiver_name`, `receiver_phone_no`, `receiver_area_id`, `receiver_sub_area_id`, `receiver_address`, `note`, `delivery_fees`, `order_fees`, `total_fees`, `payment_method`, `status`, `invoice_sn`, `order_weight`, `order_value`, `number_of_pieces`) VALUES ('12', '2', '2', '1', 'jksa ', '0915477450', '1', '4', 'jksa ', 'Jksa', 'jksa ', '1', '2', '123123', '213', '200', '200', '200', 'on_sending', 'pickup', '123', '20', '20', '30');"
        );
    }
}