<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Goods;
use App\Description;
use App\Category;
use App\Subcategory;
use App\Size;
use App\Color;
use App\GoodsSizes;
use App\ColorGoodsSizes;
use App\CategorySubcat;
use App\Picture;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// factory(Goods::class, 10)->create()
	    // 	->each(function ($g) {
		   //      $g->descriptions()->save(factory(Description::class)->make());
		   //      })
	    // 	->each(function ($g) {
		   //      $g->category()->save(factory(Category::class)->make());
		   //  	})
	    // 	->each(function ($g) {
		   //      $g->subcategory()->save(factory(Subcategory::class)->make());
		   //  	})
	    // ;

	    $descriptionCount = Description::count();
	    $categoryCount = Category::count();
	    $subcatCount = Subcategory::count();
	    $sizeCount = Size::count();
	    $colorCount = Color::count();
	    $pictureCount = Picture::count();

	    // `echo "  -----------------------------------------------------------------------------  " >>/tmp/qaz`;

        for ($k = 1; $k <= $descriptionCount ; $k++) { 
        	$goods = new Goods;
	        $goods->title = 'Good' . $k;
	        $goods->descriptions()->associate($k);
	        $goods->category()->associate(rand(1, $categoryCount));
	        $goods->subcategory()->associate(rand(1, $subcatCount));
	        $goods->save();

	        $sizeArr = [];
	        $max = rand(1,5);
	        for ($i=0; $i <= $max; $i++) { 
	        	$tmp = rand(1, $sizeCount);
	        	if($i==0){
	        		$sizeArr[] = $tmp;
	        	}
	        	if(!in_array($tmp, $sizeArr)){
	        		$sizeArr[] = $tmp;
	        	}	
	        }

	        $goods->size()->attach($sizeArr);
	        $goods->save();

	        $goodsSizes = GoodsSizes::where('goods_id', $goods->id)->get();

	        $colorArr = [];
	        for ($j=0; $j < count($sizeArr); $j++) {
	        	$max = rand(1,5); 
	        	for ($i=0; $i < $max; $i++) {
	        		$tmp = rand(1, $colorCount); 
	        		if($i==0){
		        		$colorArr[$j][] = $tmp;
		        	}
		        	if(!in_array($tmp, $colorArr[$j])){
		        		$colorArr[$j][] = $tmp;
		        	}	
		        }
	        }

	        $i = 0;
	        foreach ($goodsSizes as $goodSize) {

	                $goodSize->color()->attach($colorArr[$i]);

	                $allColors[] = $colorArr[$i];

	                $colorGoodsSizes = ColorGoodsSizes::where('goods_sizes_id', $goodSize->id)->get();

	                foreach ($colorGoodsSizes as $colorGoodsSize) {
	                    $colorGoodsSize->picture()->associate(rand(1, $pictureCount));
	                    $colorGoodsSize->save();
	                }
	            $i++;
	        }

	        DB::table('category_subcats')->truncate();
	        $categories = Category::all();
	        foreach ($categories as $category){        
	            $subcats = DB::select('select distinct subcategories_id from goods where categories_id = ?', [$category->id]); 
	            foreach ($subcats as $subcat){
	                $category->subcategory()->attach($subcat);
	            }
	            $category->save();
	        }


        }
    }
}
