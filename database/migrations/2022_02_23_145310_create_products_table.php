<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('product_name', 191);
            $table->string('slug');
            $table->unsignedBigInteger('price');
            $table->text('description');
            $table->unsignedDouble('product_rate')->default(0.0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('weight')->default(0);
            $table->enum('kondisi',['new','preloved']);
            // $table->softDeletes();
            $table->timestamps();

            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
