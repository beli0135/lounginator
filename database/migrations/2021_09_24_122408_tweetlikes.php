<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tweetlikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweet_likes', function (Blueprint $table) {
            $table->increments('TWL_cdiTweetLike');
            $table->unsignedBigInteger('TWL_cdiPost');
            $table->unsignedBigInteger('TWL_cdiUser');
            $table->timestamps();

            $table->foreign('TWL_cdiPost')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('TWL_cdiUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweetlikes');
    }
}
