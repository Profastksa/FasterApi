<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderFullDataVue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement(
        //     "CREATE  VIEW `orders_full_data`  AS SELECT `orders`.`id` AS `id`, `orders`.`service_id` AS `service_id`, `orders`.`tracking_number` AS `tracking_number`, `orders`.`receipt_file` AS `receipt_file`, `orders`.`number_of_pieces` AS `number_of_pieces` ,  `orders`.`note` AS `note`, `orders`.`client_id` AS `client_id`, `orders`.`representative_id` AS `representative_id`, `orders`.`sender_name` AS `sender_name`, `orders`.`sender_phone` AS `sender_phone`, `orders`.`sender_area_id` AS `sender_area_id`, `orders`.`sender_sub_area_id` AS `sender_sub_area_id`, `orders`.`sender_address` AS `sender_address`, `orders`.`receiver_name` AS `receiver_name`, `orders`.`receiver_phone_no` AS `receiver_phone_no`, `orders`.`receiver_area_id` AS `receiver_area_id`, `orders`.`receiver_sub_area_id` AS `receiver_sub_area_id`, `orders`.`receiver_address` AS `receiver_address`, `orders`.`police_file` AS `police_file`, `orders`.`is_police_file_sent` AS `is_police_file_sent`, `orders`.`delivery_fees` AS `delivery_fees`, `orders`.`order_fees` AS `order_fees`, `orders`.`total_fees` AS `total_fees`, `orders`.`order_value` as `order_value` , `orders`.`payment_method` AS `payment_method`, `orders`.`is_company_fees_collected` AS `is_company_fees_collected`, `orders`.`order_date` AS `order_date`, `orders`.`order_weight` AS `order_weight`, `orders`.`delivery_date` AS `delivery_date`, `orders`.`status` AS `status`, `orders`.`transaction_id` AS `transaction_id`, `orders`.`invoice_sn` AS `invoice_sn`, `orders`.`is_deleted` AS `is_deleted`, `orders`.`created_at` AS `created_at`, `orders`.`updated_at` AS `updated_at`, `clients`.`fullname` AS `client_name`, `representatives`.`fullname` AS `representative_name`, `services`.`name` AS `service_name`, `sender_area`.`name` AS `sender_area_name`, `sender_sub_area`.`name` AS `sender_sub_area_name`, `receiver_area`.`name` AS `receiver_area_name`, `receiver_sub_area`.`name` AS `receiver_sub_area_name` FROM (((((((`orders` left join `representatives` on(`representatives`.`id` = `orders`.`representative_id`)) left join `clients` on(`clients`.`id` = `orders`.`client_id`)) left join `services` on(`services`.`id` = `orders`.`service_id`)) left join `areas` `sender_area` on(`sender_area`.`id` = `orders`.`sender_area_id`)) left join `sub_areas` `sender_sub_area` on(`sender_sub_area`.`id` = `orders`.`sender_sub_area_id`)) left join `areas` `receiver_area` on(`receiver_area`.`id` = `orders`.`receiver_area_id`)) left join `sub_areas` `receiver_sub_area` on(`receiver_sub_area`.`id` = `orders`.`receiver_sub_area_id`))"
        // );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement("DROP VIEW `orders_full_data`");
    }
}
