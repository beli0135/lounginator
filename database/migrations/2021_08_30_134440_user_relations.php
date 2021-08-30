<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relations', function (Blueprint $table) {
            $table->increments('URR_cdiUserRelation');
            $table->unsignedBigInteger('URR_cdiUser');
            $table->unsignedBigInteger('URR_cdiUserRelated');
            $table->boolean('URR_isFavorite')->default(false);
            $table->boolean('URR_isMuted')->default(false);
            $table->boolean('URR_isBlocked')->default(false);
            
            $table->timestamps();

            $table->foreign('URR_cdiUser')->references('id')->on('users')->onDelete('cascade');
            $table->index('URR_cdiUserRelated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relations');
    }
}
