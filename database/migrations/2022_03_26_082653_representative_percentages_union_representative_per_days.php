<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RepresentativePercentagesUnionRepresentativePerDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // DB::statement(
        //     "CREATE  VIEW IF NOT EXISTS  `representative_percentages_union_representative_per_days`  AS SELECT `representative_orders_percentages`.`representative_id` AS `representative_id`, `representative_orders_percentages`.`deserve` AS `deserve`, `representative_orders_percentages`.`is_paid` AS `is_paid`, `representative_orders_percentages`.`payment_date` AS `payment_date`, `representative_orders_percentages`.`transaction_id` AS `transaction_id`, `representative_orders_percentages`.`created_at` AS `created_at`, `representative_orders_percentages`.`updated_at` AS `updated_at` FROM `representative_orders_percentages`            "
        // );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (!Schema::hasTable('representative_percentages_union_representative_per_days')) {

       // DB::statement("drop view `representative_percentages_union_representative_per_days`");
        }
    }
}
