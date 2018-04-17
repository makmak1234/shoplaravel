<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DescriptionTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(SizesTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SubcatTableSeeder::class);
        $this->call(PriceTableSeeder::class);
        $this->call(GoodsTableSeeder::class);
    }
}
