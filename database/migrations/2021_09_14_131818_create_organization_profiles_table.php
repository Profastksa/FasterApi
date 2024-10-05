<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('name');
            $table->text('address');
            $table->string('phone_no');
            $table->string('whatsapp_no');
            $table->text('pravicy_en')->nullable();
            $table->text('pravicy_ar')->nullable();
            $table->string('countery_key')->default('+123');
            $table->string('email');
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
        Schema::dropIfExists('organization_profiles');
    }
}
