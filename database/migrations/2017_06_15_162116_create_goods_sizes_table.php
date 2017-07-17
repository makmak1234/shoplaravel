<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sizes', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('sizes_id')->unsigned();
            $table->foreign('sizes_id')
              ->references('id')->on('sizes')
              ->onDelete('cascade')->onEdit('cascade');

            $table->integer('goods_id')->unsigned();
            $table->foreign('goods_id')
              ->references('id')->on('goods')
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
            Schema::table('goods_sizes', function (Blueprint $table) {
                $table->dropForeign("sizes_id");
                $table->dropForeign("goods_id");
            });
            //Schema::drop('sizes_id');

        Schema::dropIfExists('goods_sizes');
    }
}
