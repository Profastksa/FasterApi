<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueClientStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_client_statements', function (Blueprint $table) {
            $table->id();
            $table->integer('total_shiping_type');
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->integer('total_deleviry_fess')->nullable();
            $table->integer('total_order_fess')->nullable();
            $table->integer('total_service_fess')->nullable();
            $table->integer('total_fess')->nullable();
            $table->json('orders_ids')->nullable();
            $table->timestamp('issue_date')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->double('tax', 15, 8)->nullable()->default();
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
        Schema::dropIfExists('issue_client_statements');
    }
}
