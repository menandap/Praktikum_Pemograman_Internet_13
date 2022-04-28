<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('courier_id')->unsigned();
            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('cascade');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->dateTime('timeout')->nullable();
            $table->string('address', 191);
            $table->double('total', 12, 2)->nullable();
            $table->double('shipping_cost', 12, 2)->nullable();
            $table->double('sub_total', 12, 2);
            $table->string('proof_of_payment', 191)->nullable();
            $table->string('code');
            $table->string('slug');
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('shipping_package', 100)->nullable();
            $table->enum('status', ['pending', 'unpaid', 'paid', 'admin_verified', 'admin_notverified', 'admin_deliver', 'success', 'expired', 'canceled'])->default('pending');
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
        Schema::dropIfExists('transactions');
    }
}
