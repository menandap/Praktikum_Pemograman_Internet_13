<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('notifiable_type');
            $table->integer('notifiable_id')->unsigned();
            $table->foreign('notifiable_id')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // $table->foreign('notifiable_id')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_notifications');
    }
}
