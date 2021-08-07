<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('name');
        });

        DB::table('roles')->insert(
            array(
                'id' => 1,
                'name' => 'User'
            )
        );

        DB::table('roles')->insert(
            array(
                'id' => 2,
                'name' => 'Admin'
            )
        );

        DB::table('roles')->insert(
            array(
                'id' => 3,
                'name' => 'Moderator'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
