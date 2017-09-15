<?php

use Illuminate\Database\Seeder;
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
    	// factory(App\Goods::class, 10)->create()->each(function ($g) {
	    //     $g->descriptions()->save(factory(App\Description::class)->make());
	    //     $g->category()->save(factory(App\Category::class)->make());
	    //     $g->subcategory()->save(factory(App\Subategory::class)->make());
	    // });

	    $descriptionCount = Description::count();
	    // $description = Description::all();
	    $categoryCount = Category::count();
	    $subcatCount = Subcategory::count();
	    $sizeCount = Size::count();
	    $colorCount = Color::count();
	    $pictureCount = Picture::count();

	    `echo "  -----------------------------------------------------------------------------  " >>/tmp/qaz`;

        for ($k = 1; $k <= $descriptionCount ; $k++) { 
        	$goods = new Goods;
	        $goods->title = 'Good' . $k;
	        $goods->descriptions()->associate($k);//($descriptions);
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

	        $myecho = json_encode($goodsSizes);
	        `echo " goodsSizes:    " >>/tmp/qaz`;
	        `echo "$myecho" >>/tmp/qaz`;
	        // exit;

	        $myecho = json_encode($colorArr);
	        `echo " colorArr:    " >>/tmp/qaz`;
	        `echo "$myecho" >>/tmp/qaz`;
	        // exit;

	        $i = 0;
	        foreach ($goodsSizes as $goodSize) {

	            // if(isset($colorArr[$i])){
	                $goodSize->color()->attach($colorArr[$i]);

	                $allColors[] = $colorArr[$i];

	                $colorGoodsSizes = ColorGoodsSizes::where('goods_sizes_id', $goodSize->id)->get();

	                //$pict_radio = $request->pict_radio;
	                foreach ($colorGoodsSizes as $colorGoodsSize) {
	                    // $myecho = json_encode($pict_radio[$colorGoodsSize->colors_id]);
	                    // `echo " pict_radio[colorGoodsSize->colors_id]:    " >>/tmp/qaz`;
	                    // `echo "$myecho" >>/tmp/qaz`;
	                    // //exit;
	                    $colorGoodsSize->picture()->associate(rand(1, $pictureCount));
	                    $colorGoodsSize->save();
	                }
	            // }
	            $i++;
	        }

	        DB::table('category_subcats')->truncate();
	        $categories = Category::all();
	        foreach ($categories as $category){        
	            //$goods = App\Goods::where('categories_id', $category->id)->get();
	            $subcats = DB::select('select distinct subcategories_id from goods where categories_id = ?', [$category->id]); 
	            foreach ($subcats as $subcat){
	                $category->subcategory()->attach($subcat);
	            }
	            $category->save();
	        }


        }
    }
}
