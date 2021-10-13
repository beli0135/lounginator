<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('NTC_cdiNotification');
            $table->unsignedBigInteger('NTC_cdiUser');
            $table->unsignedBigInteger('NTC_cdiPost')->nullable();
            $table->boolean('NTC_isRead')->default(false);
            $table->string('NTC_dssNotification')->nullable();
            $table->timestamps();

            $table->foreign('NTC_cdiUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
