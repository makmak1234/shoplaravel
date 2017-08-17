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
            $table->foreign('descriptions_id')->references('id')->on('descriptions');
            $table->integer('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->integer('subcategories_id')->unsigned();
            $table->foreign('subcategories_id')->references('id')->on('subcategories');
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
                $table->dropForeign("categories_id");
                $table->dropForeign("subcategories_id");
                $table->dropForeign("descriptions_id");
            });

        //Schema::dropIfExists('goods');
    }
}
