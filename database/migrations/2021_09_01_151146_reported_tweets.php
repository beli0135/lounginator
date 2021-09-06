<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportedTweets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_tweets', function (Blueprint $table) {
            $table->increments('RTW_cdiReportedTweet');
            $table->unsignedBigInteger('RTW_cdiUserReporting');
            $table->unsignedBigInteger('RTW_cdiUserReported');
            $table->unsignedBigInteger('RTW_cdiPost');
            $table->boolean('RTW_isRead')->default(false);
            $table->mediumText('RTW_dssAction')->nullable();
            
            $table->timestamp('RTW_created_at', 0)->nullable();
            $table->timestamp('RTW_updated_at', 0)->nullable();

            $table->foreign('RTW_cdiUserReported')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('RTW_cdiUserReporting')->references('id')->on('users');
            $table->index('RTW_cdiPost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_tweets');
    }
}
