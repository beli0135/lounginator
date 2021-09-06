<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtags', function (Blueprint $table) {
            $table->increments('HTG_id');
            $table->unsignedBigInteger('HTG_post_id');
            $table->string('HTG_hashtag');
            $table->timestamps();
            
            $table->foreign('HTG_post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->index('HTG_hashtag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hashtags');
    }
}
