<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

            // $table->foreignId('province_id')->constrained('provinces');
            // $table->foreignId('province_id')
            //         ->constrained('provinces')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
            // $table->string('province', 120)->nullable();
            $table->string('type');
            $table->string('city_name');
            $table->string('postal_code');
            $table->timestamps();



            // $table->integer('peminjam_id')->unsigned();
            // $table->foreign('peminjam_id')->references('id')->on('peminjam')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
