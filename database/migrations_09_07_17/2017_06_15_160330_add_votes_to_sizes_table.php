<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->integer('size_titles_id')->unsigned();
            $table->foreign('size_titles_id')
              ->references('id')->on('size_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('sizes', function (Blueprint $table) {
                $table->dropForeign("size_titles_id");
            });

            Schema::drop('size_titles_id');
    }
}
