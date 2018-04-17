<?php

use Illuminate\Database\Seeder;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=30; $i++){
            $tmp = rand(10, 50); 
        	DB::table('prices')->insert([
	            'rub' => $tmp*60,
                'uah' => $tmp*26,
                'usd' => $tmp,
                'eur' => $tmp/1.2,
	        ]);
        }
    }
}
