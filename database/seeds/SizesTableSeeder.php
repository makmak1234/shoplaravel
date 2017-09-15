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
        $sizeCall  = array();
        $sizeCall[] = 'S';
        $sizeCall[] = 'M';
        $sizeCall[] = 'L';
        $sizeCall[] = 'X';
        $sizeCall[] = 'XS';
        $sizeCall[] = 'XL';
        $sizeCall[] = 'XXL';
        $sizeCall[] = 'XXXL';

        for ($i = 0; $i < count($sizeCall); $i++) {           
            DB::table('sizes')->insert([
	            'title' => $sizeCall[$i],
	        ]);
        }
    }
}
