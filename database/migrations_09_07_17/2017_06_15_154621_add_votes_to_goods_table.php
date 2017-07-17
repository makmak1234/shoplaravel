<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->integer('descriptions_id')->unsigned();
            $table->foreign('descriptions_id')
              ->references('id')->on('descriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('goods', function (Blueprint $table) {
                $table->dropForeign("descriptions_id");
            });

            Schema::drop('descriptions_id');
    }
}
