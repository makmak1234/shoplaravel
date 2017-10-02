<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Color;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;

class CrudColorController extends Controller
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

        $colors = new Color;

        $colors->title = $request->title;

        $colors->save();

        

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
    public function insertColor()
    {

        return view('backend.insert_color');
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
    public function storeColor(Request $request)
    {
        // Validate the request...

        $color = new Color;

        //$descriptions = new Description;

        $color->title = $request->title;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $color->save();

        $this->clearCache();

        return redirect()->route('showColor');

        // $goods = Goods::all();

        // return view('welcome', ["goods" => $goods]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showColor()
    {
        $colors = Color::all();

        return view('backend.show_color', ["colors" => $colors]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editColor($id)
    {
        $color = Color::find($id);

        return view('backend.edit_color', ["color" => $color]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditColor(Request $request)
    {
        $color = Color::find($request->id);

        $color->title = $request->title;

        $color->save();
        
        $this->clearCache();

        return redirect()->route('showColor');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowColor(Request $request)
    {
        $id = $request->id;
        $del_desc = $request->del_desc;

        $size = Color::find($id)->delete();

        $this->clearCache();

        return response()->json(["success" => true, "message" => "Запись удалена"]);

        //$id = $request->id; 
        // `echo $id >>/tmp/qaz`;

        // $color = Color::find($id);

        // `echo $color >>/tmp/qaz`;
        // `echo $del_size >>/tmp/qaz`;

        // if ($del_size == 'true') {
        //     $size = $color->size;
        //     //$good->descriptions()->associate($descriptions);
        //     $size->delete();
        //     $color->delete();
        //     return 'Ok';
        // }

        // `echo $color >>/tmp/qaz`;
        // $color->delete();
        
        // return 'Ok';
        //exit;
    }

    private function clearCache(){
        $categories = Category::all();
        foreach ($categories as $category) {
            if (Cache::has('showTables'.$category->id)) {
                Cache::forget('showTables'.$category->id);
            }
        }
        
        $goods = Goods::all();
        foreach ($goods as $good) {
            $goodShow = 'good'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id;
            if (Cache::has($goodShow)) {
                Cache::forget($goodShow);
            }
        }
    }


}