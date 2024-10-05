<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("trans_sn");
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references("id")->on("users");
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references("id")->on("clients");
            $table->unsignedBigInteger('representative_id')->nullable();
            $table->foreign('representative_id')->references("id")->on("representatives");
            $table->timestamp("date");
            $table->double("amount");
            $table->unsignedBigInteger("transaction_type_id");
            $table->foreign("transaction_type_id")->references("id")->on("transactions_types");
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
        Schema::dropIfExists('transactions');
    }
}
