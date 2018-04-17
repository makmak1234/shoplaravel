<?php

use Illuminate\Database\Seeder;

class SubcatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++){
        	DB::table('subcategories')->insert([
	            'en' => 'subcategory ' . $i,
                'ru' => 'субкатегория ' . $i,
	        ]);
        }    
    }
}
