<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colorCall  = array();
        $colorCall[] = 'red';
        $colorCall[] = 'green';
        $colorCall[] = 'blue';
        $colorCall[] = 'pink';
        $colorCall[] = 'grey';
        $colorCall[] = 'black';
        $colorCall[] = 'white';
        $colorCall[] = 'yellow';

    	for ($i = 0; $i < count($colorCall); $i++) {           
            DB::table('colors')->insert([
	            'title' => $colorCall[$i],
	        ]);
        }
    }
}
