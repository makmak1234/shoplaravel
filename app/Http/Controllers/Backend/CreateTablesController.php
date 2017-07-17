<?php

namespace App\Http\Controllers\Backend;

//use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function createTables()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
        });

        return view('backend.create_table', ['create_table' => 'таблица создана']);
    }
}