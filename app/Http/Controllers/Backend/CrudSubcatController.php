<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Category;
use App\Subcategory;
use App\CategorySubcat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CrudSubcatController extends Controller  
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

        $subcat = new Subcategory;

        $subcat->title = $request->title;

        $subcat->save();
        
        $this->clearCache($subcat);
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
    public function insertSubcat()
    {

        return view('backend.insert_subcat');
    }

    public function writeValidTables()
    {

        return view('backend.write_tables');
    }

    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeSubcat(Request $request)
    {
        // Validate the request...

        $subcat = new Subcategory;

        //$descriptions = new Description;

        $subcat->en = $request->en;
        $subcat->ru = $request->ru;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $subcat->save();
        
        $this->clearCache($subcat);

        return redirect()->route('showSubcat');

        // $goods = Goods::all();

        // return view('welcome', ["goods" => $goods]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showSubcat()
    {
        $subcats = Subcategory::all();

        return view('backend.show_subcat', ["subcats" => $subcats]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editSubcat($id)
    {
        $subcat = Subcategory::find($id);

        return view('backend.edit_subcat', ["subcat" => $subcat]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditSubcat(Request $request)
    {
        $subcat = Subcategory::find($request->id);

        $subcat->en = $request->en;
        $subcat->ru = $request->ru;

        $subcat->save();
        
        $this->clearCache($subcat);

        return redirect()->route('showSubcat');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowSubcat(Request $request)
    {
        //$id = $request->id; 
        //`echo $id >>/tmp/qaz`;
        $id = $request->id;
        $del_subcat = $request->del_subcat;

        $subcat = Subcategory::find($id);
        
        $this->clearCache($subcat);

        $subcat->delete();

        return response()->json(["success" => true, "message" => "Запись удалена"]);

        // `echo $size >>/tmp/qaz`;
        // `echo $del_good >>/tmp/qaz`;

        // if ($del_good == 'true') {
        //     $good = $size->good;
        //     //$good->descriptions()->associate($descriptions);
        //     $size->delete();
        //     $good->delete();
        //     return 'Ok';
        // }

        // `echo $size >>/tmp/qaz`;
        // $size->delete();
        
        // return 'Ok';
        // //exit;
    }

    private function clearCache($subcat){
        if (Cache::has('index_en')) {
            Cache::forget('index_en');
        }
        if (Cache::has('index_ru')) {
            Cache::forget('index_ru');
        }

        // $categories = CategorySubcat::where(['subcategory_id',$subcat->id]);
        $categories = DB::select('select category_id from category_subcats where subcategory_id = ?', [$subcat->id]); 
        // $myecho = json_encode($categories);
        // `echo " categories    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        foreach ($categories as $category) {
            // $myecho = json_encode($category->category_id);
            // `echo " category->category_id    " >>/tmp/qaz`;
            // `echo "$myecho" >>/tmp/qaz`;
            if (Cache::has('catSubcat_en'.$category->category_id.'_'.$subcat->id)) {
                Cache::forget('catSubcat_en'.$category->category_id.'_'.$subcat->id);
            }
            if (Cache::has('catSubcat_ru'.$category->category_id.'_'.$subcat->id)) {
                Cache::forget('catSubcat_ru'.$category->category_id.'_'.$subcat->id);
            }
            $goods = Goods::where([
                  ['categories_id', '=', $category->category_id],
                  ['subcategories_id', '=', $subcat->id],
              ])->get();
            foreach ($goods as $good) {
                $goodShow = 'good_en'.$category->category_id.'_'.$subcat->id.'_'.$good->id;
                if (Cache::has($goodShow)) {
                    Cache::forget($goodShow);
                }
                $goodShow = 'good_ru'.$category->category_id.'_'.$subcat->id.'_'.$good->id;
                if (Cache::has($goodShow)) {
                    Cache::forget($goodShow);
                }
            }
        }

    }


}