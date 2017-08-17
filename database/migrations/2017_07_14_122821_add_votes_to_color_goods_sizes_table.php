<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToColorGoodsSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('color_goods_sizes', function (Blueprint $table) {
            $table->integer('pictures_id')->unsigned()->nullable();
            $table->foreign('pictures_id')
              ->references('id')->on('pictures')
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
        Schema::table('color_goods_sizes', function (Blueprint $table) {
            $table->dropForeign("pictures_id");
        });

       // Schema::dropIfExists('color_goods_sizes');
    }
}
