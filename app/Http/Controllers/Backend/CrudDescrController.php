<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Color;
use App\Category;
use App\Subcategory;
use App\Description;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\DB;

class CrudDescrController extends Controller
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
    public function insertDescr()
    {

        return view('backend.insert_descr');
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
    public function storeDescr(Request $request)
    {
        // Validate the request...

        $descr = new Description;

        //$descriptions = new Description;

        $descr->title = $request->title;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $descr->save();
        
        $this->clearCache($descr->id);

        return redirect()->route('showDescr');

        // $goods = Goods::all();

        // return view('welcome', ["goods" => $goods]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showDescr()
    {
        $descrs = Description::all();

        return view('backend.show_descrs', ["descrs" => $descrs]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editDescr($id)
    {
        $descr = Description::find($id);

        return view('backend.edit_descr', ["descr" => $descr]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditDescr(Request $request)
    {
        $descr = Description::find($request->id);

        $descr->title = $request->title;

        $descr->save();
        
        $this->clearCache($descr->id);

        return redirect()->route('showDescr');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowDescr(Request $request)
    {
        //$id = $request->id; 
        //`echo $id >>/tmp/qaz`;
        $id = $request->id;
        $del_desc = $request->del_desc;

        $size = Description::find($id)->delete();

        $this->clearCache($descr->id);

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

    private function clearCache($descr_id){
        $goods = Goods::where('descriptions_id', $descr_id)->get();

        // $myecho = json_encode($goods);
        // `echo " goods    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
    
        foreach ($goods as $good) {
            $goodShow = 'good'.$good->categories_id.'_'.$good->subcategories_id.'_'.$good->id;
            if (Cache::has($goodShow)) {
                Cache::forget($goodShow);
            }
        }
    }



}