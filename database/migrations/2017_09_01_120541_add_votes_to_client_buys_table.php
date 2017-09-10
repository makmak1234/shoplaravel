<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToClientBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_buys', function (Blueprint $table) {
            $table->integer('client_registr_id')->unsigned();
            $table->foreign('client_registr_id')
              ->references('id')->on('client_registrs')
              ->onDelete('cascade')->onEdit('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_buys', function (Blueprint $table) {
            $table->dropForeign("client_registr_id");
        });
        Schema::dropIfExists('client_buys');
    }
}
