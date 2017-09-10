<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientBuysTable extends Migration
{
    protected $fillable = ['size', 'color', 'nid', 'priceone', 'valuta'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_buys', function (Blueprint $table) {
            $table->increments('id');
            //$table->timestamps();
            $table->string('size');
            $table->string('color');
            $table->integer('nid');
            $table->decimal('priceone', 8, 2);
            $table->string('valuta');

            $table->integer('good_id')->unsigned();
            $table->foreign('good_id')
              ->references('id')->on('goods');
              // ->onDelete('cascade')->onEdit('cascade');

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
            $table->dropForeign("good_id");
        });
        
    }
}
