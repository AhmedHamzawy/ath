<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(1);
            $table->string('name_ar');
            $table->string('name_en');            
            $table->string('certificate');
            $table->string('dateofbirth');
            $table->decimal('cost');
            $table->text('description_ar');
            $table->text('description_en');
            $table->integer('rating')->default(0);
            $table->text('image')->nullable();
            $table->boolean('state')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('status_id')->references('id')->on('statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
