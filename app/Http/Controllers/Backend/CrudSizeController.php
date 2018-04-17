<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Size;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;

class CrudSizeController extends Controller
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
        
        $this->clearCache();
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
    public function insertSize()
    {

        return view('backend.insert_size');
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
    public function storeSize(Request $request)
    {
        // Validate the request...

        $size = new Size;

        //$descriptions = new Description;

        $size->en = $request->en;
        $size->ru = $request->ru;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $size->save();
        
        $this->clearCache();

        return redirect()->route('showSize');

        // $goods = Goods::all();

        // return view('welcome', ["goods" => $goods]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showSize()
    {
        $sizes = Size::all();

        return view('backend.show_sizes', ["sizes" => $sizes]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editSize($id)
    {
        $size = Size::find($id);

        return view('backend.edit_size', ["size" => $size]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditSize(Request $request)
    {
        $size = Size::find($request->id);

        $size->en = $request->en;
        $size->ru = $request->ru;

        $size->save();
        
        $this->clearCache();

        return redirect()->route('showSize');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowSize(Request $request)
    {
        $id = $request->id;
        $del_desc = $request->del_desc;
        
        $size = Size::find($id)->delete();
        
        $this->clearCache();
        
        return response()->json(["success" => true, "message" => "Запись удалена"]);

        //$id = $request->id; 
        // `echo $id >>/tmp/qaz`;

        // $size = Size::find($id);

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
        //exit;
    }

    private function clearCache(){
        $categories = Category::all();
        foreach ($categories as $category) {
            if (Cache::has('showTables_en'.$category->id)) {
                Cache::forget('showTables_en'.$category->id);
            }
            if (Cache::has('showTables_ru'.$category->id)) {
                Cache::forget('showTables_ru'.$category->id);
            }
        }
        
        $goods = Goods::all();
        foreach ($goods as $good) {
            $goodShow = 'good_en'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id;
            if (Cache::has($goodShow)) {
                Cache::forget($goodShow);
            }
            $goodShow = 'good_ru'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id;
            if (Cache::has($goodShow)) {
                Cache::forget($goodShow);
            }
        }
    }


}