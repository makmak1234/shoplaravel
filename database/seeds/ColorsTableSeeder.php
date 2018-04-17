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
        $colorCallen  = array();
        $colorCallen[] = 'red';
        $colorCallen[] = 'green';
        $colorCallen[] = 'blue';
        $colorCallen[] = 'pink';
        $colorCallen[] = 'grey';
        $colorCallen[] = 'black';
        $colorCallen[] = 'white';
        $colorCallen[] = 'yellow';
        $colorCallru  = array();
        $colorCallru[] = 'красный';
        $colorCallru[] = 'зеленый';
        $colorCallru[] = 'синий';
        $colorCallru[] = 'розовый';
        $colorCallru[] = 'коричневый';
        $colorCallru[] = 'черный';
        $colorCallru[] = 'белый';
        $colorCallru[] = 'желтый';

    	for ($i = 0; $i < count($colorCallen); $i++) {           
            DB::table('colors')->insert([
	            'en' => $colorCallen[$i],
                'ru' => $colorCallru[$i],
	        ]);
        }
    }
}
