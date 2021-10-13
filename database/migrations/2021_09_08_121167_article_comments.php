<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArticleComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_comments', function (Blueprint $table) {
            $table->increments('ACM_cdiComment');
            $table->unsignedBigInteger('ACM_cdiPost');
            $table->unsignedBigInteger('ACM_cdiOfComment')->default(0);
            $table->string('ACM_dssUsername');
            $table->string('ACM_dssUserFullName');
            $table->string('ACM_dssProfileImage');
            $table->mediumText('ACM_dssComment');
            $table->unsignedInteger('ACM_cntGood')->default(0);
            $table->unsignedInteger('ACM_cntBad')->default(0);
            $table->boolean('ACM_nsfw')->default(false);
            $table->string('ACM_image_path')->nullable();
            $table->timestamps();
            
            $table->foreign('ACM_cdiPost')->references('id')->on('posts')->onDelete('cascade');
            $table->index('ACM_dssUsername');
            $table->index('ACM_cdiOfComment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_comments');
    }
}
