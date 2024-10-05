<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDetailsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     //
        // });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('cash_amount', 10, 2)->default(0); // Adjust the position with 'after' as needed
            $table->string('COD_payment_method')->nullable();
            $table->decimal('E_transfer_amount', 10, 2)->default(0)->after('COD_payment_method');
            $table->string('E_transfer_number')->nullable()->after('E_transfer_amount');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
