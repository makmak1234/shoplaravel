<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRegistrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_registrs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('orderclient');
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('tel');
            $table->string('email')->nullable();
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_registrs');
    }
}
