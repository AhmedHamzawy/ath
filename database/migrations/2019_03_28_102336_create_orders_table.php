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
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('hospital_id')->unsigned()->nullable();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned();
            $table->string('name');
            $table->string('date_time');
            $table->string('lat');
            $table->string('lon');
            $table->string('phone');
            $table->decimal('cost', 8, 2);
            $table->integer('commission_status');
            $table->text('other');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('hospital_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('state_id')->references('id')->on('states');

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
