<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativeOrdersPerDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representative_orders_per_days', function (Blueprint $table) {
            $table->id();
            $table->timestamp("date");
            $table->unsignedBigInteger('representative_id');
            $table->foreign('representative_id')->references('id')->on('representatives');
            $table->integer('orders_count');
            $table->integer('deserve');
            $table->boolean('is_paid')->default(0);
            $table->timestamp('payment_date')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('representative_orders_per_days');
    }
}
