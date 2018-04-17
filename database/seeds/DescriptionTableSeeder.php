<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=30; $i++){
        	DB::table('descriptions')->insert([
	            'en' => 'description ' . $i,
                'ru' => 'описание ' . $i,
	        ]);
        }
    }
}
