<?php

use App\Models\OrderShiping;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShiping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('order_shipings')) {
            Schema::create('order_shipings', function (Blueprint $table) {
                $table->id();
                $table->enum('shipping_type', OrderShiping::TYPES)->nullable();
                $table->foreignId('order_id')->references('id')->on('orders');
                $table->string('refrence_id', 20)->nullable();
                $table->timestamps();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_shiping');
    }
}
