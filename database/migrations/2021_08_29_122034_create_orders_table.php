<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('representative_id')->nullable();
            $table->foreign('representative_id')->references('id')->on('representatives');
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->unsignedBigInteger('sender_area_id');
            $table->foreign('sender_area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('sender_sub_area_id');
            $table->foreign('sender_sub_area_id')->references('id')->on('sub_areas');
            $table->text('sender_address');
            $table->string('receiver_name');
            $table->string('receiver_phone_no');
            $table->unsignedBigInteger('receiver_area_id');
            $table->foreign('receiver_area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('receiver_sub_area_id');
            $table->foreign('receiver_sub_area_id')->references('id')->on('sub_areas');
            $table->text('receiver_address');
            $table->string('police_file')->nullable();
            $table->string('receipt_file')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_police_file_sent')->default(0);
            $table->double('delivery_fees')->nullable();
            $table->double('order_fees')->nullable();
            $table->double('total_fees')->nullable();
            // $table->double('representative_deserves')->nullable();
            // $table->double('company_deserves')->nullable();
            $table->enum('cod_method', ['cash', 'network']);
            $table->enum('payment_method', ['on_sending', 'on_receiving', 'balance']);
            // $table->boolean('is_payment_on_delivery')->default(0);
            $table->boolean('is_company_fees_collected')->default(0);
            $table->boolean('is_client_payment_made')->default(0);
            $table->timestamp('order_date')->default(date('Y-m-d H:i:s'));
            $table->timestamp('delivery_date')->nullable();
            $table->enum('status', Order::STATUS);
            $table->unsignedBigInteger("transaction_id")->nullable();
            $table->foreign("transaction_id")->references("id")->on("transactions");
            $table->unsignedBigInteger("client_payment_transaction_id")->nullable();
            $table->foreign("client_payment_transaction_id")->references("id")->on("transactions");
            $table->string('invoice_sn');
            $table->string('order_weight')->nullable();
            $table->string('order_value')->nullable();
            $table->integer('number_of_pieces')->nullable();
            $table->boolean('is_collected')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->string('image');


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
        Schema::dropIfExists('orders');
    }
}
