<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('sub_area_id');
            $table->foreign('sub_area_id')->references('id')->on('sub_areas');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('password')->nullable();
            $table->text('message_token')->nullable();
            $table->string('phone');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_approved')->default(0);
            $table->double('discount_rate')->nullable()->default(0);
            $table->double('account_balance')->nullable()->default(0);
            $table->boolean('is_has_custom_price')->default(0);
            $table->boolean('in_accounts_order')->default(0);
            $table->boolean('is_guest')->default(0);
            $table->string('civil_registry')->nullable();
            $table->enum('client_type' , ['normal', 'company'])->nullable();
            $table->string('bank')->nullable();
            $table->string('activity')->nullable();
            $table->string('name_in_invoice')->nullable();
            $table->string('bank_account_owner')->nullable();
            $table->integer('bank_account_number')->nullable();
            $table->integer('iban_number')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('clients');
    }
}
