<?php

namespace App\Http\Controllers\Backend;

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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
//use Intervention\Image\ImageManager;
//use Illuminate\Support\Facades\DB;

class CrudTablesController extends Controller
{
    /**
     * Create a new goods instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validate the request...

        $goods = new Goods;

        $goods->title = $request->title;

        $goods->save();
    }

    /**
     * Create a new goods instance.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function insertTables()
    {
        $descrs = Description::all();

        $categories = Category::all();

        $subcats = Subcategory::all();

        $sizes = Size::all();

        $colors = Color::all();

        $pictures = Picture::all();

        //$manager = new ImageManager(array('driver' => 'imagick'));

        return view('backend.insert_tables', ["descrs" => $descrs, "categories" => $categories, "subcats" => $subcats, "sizes" => $sizes, "colors" => $colors, "pictures" => $pictures]);//
    }

    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeTables(Request $request, $goods_del = false)
    {
        // Validate the request...

        // $myecho = json_encode($request->pict_radio[1]);
        // `echo " request->pict_radio:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;


        $goods = new Goods;
        $goods->title = $request->title;
        $goods->descriptions()->associate($request->descriptions);//($descriptions);
        $goods->category()->associate($request->category);
        $goods->subcategory()->associate($request->subcat);
        $goods->save();

        $goods->size()->attach($request->size);
        $goods->save();

        if ($goods_del == false) {
            $this->clearCache($goods);
        }else{
            $this->clearCache($goods_del);
        }
        

        // $category = Category::where('id', $request->category)->get();

        // $category[0]->subcategory()->attach($request->subcat);
        // $category[0]->save();

        $goodsSizes = GoodsSizes::where('goods_id', $goods->id)->get();
        $colors = $request->color;
        foreach ($goodsSizes as $goodSize) {
            if(isset($colors[$goodSize->sizes_id])){
                $goodSize->color()->attach($colors[$goodSize->sizes_id]);

                $allColors[] = $colors[$goodSize->sizes_id];

                $colorGoodsSizes = ColorGoodsSizes::where('goods_sizes_id', $goodSize->id)->get();

                $pict_radio = $request->pict_radio;
                foreach ($colorGoodsSizes as $colorGoodsSize) {
                    // $myecho = json_encode($pict_radio[$colorGoodsSize->colors_id]);
                    // `echo " pict_radio[colorGoodsSize->colors_id]:    " >>/tmp/qaz`;
                    // `echo "$myecho" >>/tmp/qaz`;
                    // //exit;
                    $colorGoodsSize->picture()->associate($pict_radio[$colorGoodsSize->colors_id]);
                    $colorGoodsSize->save();
                }
            }
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

        return redirect()->route('showTables');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showTables()
    {
        // Cache::flush();
        // exit;

        $good = Goods::first();

        // $myecho = json_encode($good);
        // `echo " good   " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;

        if (Cache::has('showTable'.$good->categories_id)) {
            $categories = Category::get();//remember(60)->

            return view('welcome', ["categories" => $categories]);
        }else{

            // Cache::forever('key', 'value');

            $goods = Goods::with(['descriptions', 'category', 'subcategory', 'size'])->get();//Goods::all();

            $pictures = Picture::get();//all();

            $categories = Category::get();
            $subcats = Subcategory::get();

            // $category_subcats = CategorySubcat::all();

            // $subcats = DB::select('select distinct subcategories_id from goods where categories_id = ?', [1]);

            // $subcatsmass = array();
            // foreach ($subcats as $subcat) {
            //     $subcatsmass[] = $subcat->subcategories_id;
            // }
            // $subcats = implode(',', $subcatsmass);

            // $goods2 = Goods::where([
            //     ['categories_id', '=', '1'],
            //     ['subcategories_id', '=', '1'],
            // ])->get();//DB::select('select * from goods where categories_id = ? and subcategories_id in(' . $subcats . ')', [1]); 

            // $myecho = json_encode($goods2[0]->size);
            // `echo " goods2->size    " >>/tmp/qaz`;
            // `echo "$myecho" >>/tmp/qaz`;
            //exit;

            return view('welcome', ["goods" => $goods, "pictures" => $pictures, "categories" => $categories, "subcats" => $subcats ]);//, "category_subcats" => $category_subcats
        }
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editTables($id)
    {
        $good = Goods::find($id);
        $descrs = Description::all();
        $categories = Category::all();
        $subcats = Subcategory::all();
        $sizes = Size::all();
        $colors = Color::all();
        $pictures = Picture::all();

        $cursizes = $good->size;
        foreach ($cursizes as $cursize) {
            $curszs[] = $cursize->id;
            $goodsSizes = GoodsSizes::where('id', $cursize->pivot->id)->get();
            foreach ($goodsSizes as $goodSize){
              foreach ($goodSize->color as $col){
                $curclrs[$cursize->id][] = $col->id;
                $pict = Picture::where('id', $col->pivot->pictures_id)->get();
                $pictPath[$col->id] = $pict[0]->path;
                $pictId[$col->id] = $pict[0]->id;
              }                                           
            }
        }
        // $myecho = json_encode($pictPath);
        //     `echo " pictPath:    " >>/tmp/qaz`;
        //     `echo "$myecho" >>/tmp/qaz`;
        // exit;

        return view('backend.edit_tables', ["good" => $good, "descrs" => $descrs, "categories" => $categories, "subcats" => $subcats, "sizes" => $sizes, "colors" => $colors, "curszs" => $curszs, "curclrs" => $curclrs, "pictures" => $pictures, "pictPath" => $pictPath, "pictId" => $pictId]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditTables(Request $request)
    {
        $goods = Goods::find($request->id)->delete();

        // $myecho = json_encode('showTables'.$goods->categories_id);
        // `echo " showTables:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;

        $this->storeTables($request, $goods);

        return redirect()->route('showTables');

        // -------------- пример, что делать, если обновлять без удаления--------------
        // $goods->title = $request->title;
        // $goods->descriptions()->associate($request->descriptions);
        // //$goods->save();

        // $cursizes = $goods->size()->get();
        // foreach ($cursizes as $cs) {
        //     // $myecho = json_encode($c_g_s->id);
        //     // `echo " c_g_s:    " >>/tmp/qaz`;
        //     // `echo "$myecho" >>/tmp/qaz`;
        //     $cursize[] = $cs->id;
        //     $goodsSizes = GoodsSizes::where('id', $cs->pivot->id)->get();
        //     foreach ($goodsSizes as $goodSize){
        //       foreach ($goodSize->color as $col){
        //         $curcolor[$cs->id][] = $col->id;
        //       }                                           
        //     }
        // }

        // // exit;

        // $goods->save();
        // $goods->size()->updateExistingPivot($cursize, $request->size);
        // $goods->save();

        // $goodsSizes = GoodsSizes::where('goods_id', $goods->id)->get();
        // $colors = $request->color;
        // foreach ($goodsSizes as $goodSize) {
        //     $goodSize->color()->updateExistingPivot($curcolor[], $colors[$goodSize->sizes_id]);
        // }

        return redirect()->route('showTables');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowTables(Request $request)//($id, $del_desc) (Request $request)
    {
        $id = $request->id;
        $del_desc = $request->del_desc;

        $good = Goods::find($id);

        // `echo "     " >>/tmp/qaz`;
        // `echo $id >>/tmp/qaz`;
        // `echo $del_desc >>/tmp/qaz`;
        // `echo $good >>/tmp/qaz`;

        if ($del_desc == 'true') {
            $countGoods = Goods::where('descriptions_id', $good->descriptions_id)->count();

            if ($countGoods > 1)
                return response()->json(["success" => false, "message" => "Могу удалить только запись, описание используют другие записи"]);

            $descriptions = $good->descriptions;
            //$good->descriptions()->associate($descriptions);
            $good->delete();

            $this->clearCache($good);

            $descriptions->delete();
            return response()->json(["success" => true, "message" => "Запись и описание удалены"]);
        }

        // $category = Category::where('id', $good->categories_id)->get();

        // $myecho = json_encode($category);
        // `echo " category:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;

        // $category[0]->subcategory()->detach($good->subcategories_id);
        //$category[0]->save();

        $good->delete();

        $this->clearCache($good);
        
        return response()->json(["success" => true, "message" => "Запись удалена"]);
    }

    private function clearCache($good){
        if (Cache::has('showTables'.$good->categories_id)) {
            Cache::forget('showTables'.$good->categories_id);
        }

        $catSubcat = 'catSubcat'.$good->categories_id.'_'.$good->subcategories_id;
        if (Cache::has($catSubcat)) {
            Cache::forget($catSubcat);
        }
        $goodShow = 'good'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id;
        if (Cache::has($goodShow)) {
            Cache::forget($goodShow);
        }

        $myecho = json_encode('showTables'.$good->categories_id. ' catSubcat'.$good->categories_id.'_'.$good->subcategories_id. ' good'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id);
        `echo " clearCache:    " >>/tmp/qaz`;
        `echo "$myecho" >>/tmp/qaz`;
        // exit;
    }
    
    public function artisanCommand(Request $request, $command){
        $name1 = "--verbose";
        $name2 = "--verbose";
        $value1 = "true";
        $value2 = "true";
        if ($request->has('name1')) {
          $name1 = $request->name1;
          $value1 = $request->value1;
        }
        if ($request->has('name2')) {
          $name2 = $request->name2;
          $value2 = $request->value2;
        }
        $exitCode = Artisan::call($command, [$name1 => $value1, $name2 => $value2]);
        $my_echo = $command + $name1+ "=" + $value1 + $name2 + "="+ $value2 + "  " + json_encode($exitCode);
        echo ("$command $name1=$value1 $name2=$value2");
        echo "\n";
        echo json_encode($exitCode);
      }

}