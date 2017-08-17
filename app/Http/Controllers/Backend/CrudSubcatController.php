<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;

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

        $subcat->title = $request->title;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $subcat->save();

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

        $subcat->title = $request->title;

        $subcat->save();

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

        $subcat = Subcategory::find($id)->delete();
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


}