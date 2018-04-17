<?php

use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizeCallen  = array();
        $sizeCallen[] = 'S';
        $sizeCallen[] = 'M';
        $sizeCallen[] = 'L';
        $sizeCallen[] = 'X';
        $sizeCallen[] = 'XS';
        $sizeCallen[] = 'XL';
        $sizeCallen[] = 'XXL';
        $sizeCallen[] = 'XXXL';
        $sizeCallru  = array();
        $sizeCallru[] = '28';
        $sizeCallru[] = '30';
        $sizeCallru[] = '32';
        $sizeCallru[] = '34';
        $sizeCallru[] = '36';
        $sizeCallru[] = '38';
        $sizeCallru[] = '40';
        $sizeCallru[] = '42';

        for ($i = 0; $i < count($sizeCallen); $i++) {           
            DB::table('sizes')->insert([
	            'en' => $sizeCallen[$i],
                'ru' => $sizeCallru[$i],
	        ]);
        }
    }
}
