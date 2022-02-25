<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id_orders');
            $table->unsignedBigInteger('id_customers');
            $table->unsignedBigInteger('id_officer');
            $table->date('tgl_orders');

            $table->foreign('id_customers')->references('id_customers')->on('customers');
            $table->foreign('id_officer')->references('id_officer')->on('officer');
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
