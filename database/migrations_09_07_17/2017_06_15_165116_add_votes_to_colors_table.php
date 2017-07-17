<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->integer('color_titles_id')->unsigned();
            $table->foreign('color_titles_id')
              ->references('id')->on('color_titles');

            $table->integer('goods_sizes_id');
            $table->foreign('goods_sizes_id')
              ->references('id')->on('goods_sizes')
              ->unsigned()->onDelete('cascade')->onEdit('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->dropForeign("color_titles_id");
            $table->dropForeign("goods_sizes_id");
        });
        //Schema::drop('sizes_id');
    }
}
