<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activity', function (Blueprint $table) {
            $table->increments('id');                           //  Id of Log
            $table->string('action');                           //  CRUD By User
            $table->string('content_type');                       //  Table acted upon
            $table->integer('content_id');
            $table->string('description');                       //  Row Data before change
            $table->text('details');                       //  Row Data after change
            $table->integer('user_id');                         //  User
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
        Schema::dropIfExists('log_activity');
    }
}
