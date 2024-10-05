<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFireBaseNotificationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fire_base_notification_histories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('notifcation');
            $table->string('image')->nullable();
            $table->enum('type' , ['client' ,  'representative'])->default('client');
            $table->integer('area_id')->nullable();
            $table->string('notification_date')->nullable();
            $table->string('topic')->nullable();
            $table->integer('user_id')->nullable();

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
        Schema::dropIfExists('fire_base_notification_histories');
    }
}
