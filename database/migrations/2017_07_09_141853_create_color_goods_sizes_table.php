<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorGoodsSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_goods_sizes', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('goods_sizes_id')->unsigned();
            $table->foreign('goods_sizes_id')
              ->references('id')->on('goods_sizes')
              ->onDelete('cascade')->onEdit('cascade');

            $table->integer('colors_id')->unsigned();
            $table->foreign('colors_id')
              ->references('id')->on('colors')
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
            $table->dropForeign("goods_sizes_id");
            $table->dropForeign("colors_id");
        });

        //Schema::dropIfExists('color_goods_sizes');
    }
}
