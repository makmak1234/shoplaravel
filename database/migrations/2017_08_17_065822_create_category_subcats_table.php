<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorySubcatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_subcats', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
              ->references('id')->on('categories')
              ->onDelete('cascade')->onEdit('cascade');

            $table->integer('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')
              ->references('id')->on('subcategories')
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
        Schema::table('category_subcats', function (Blueprint $table) {
                $table->dropForeign("category_id");
                $table->dropForeign("subcategory_id");
            });

        Schema::dropIfExists('category_subcats');
    }
}
