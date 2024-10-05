<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representatives', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('phone');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_approved')->default(0);
            $table->text('message_token')->nullable();
            $table->double('account_balance')->nullable()->default(0);
            // last update on representive table -------------
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->unsignedBigInteger('sub_area_id')->nullable();
            $table->foreign('sub_area_id')->references('id')->on('sub_areas');
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
        Schema::dropIfExists('representatives');
    }
}
