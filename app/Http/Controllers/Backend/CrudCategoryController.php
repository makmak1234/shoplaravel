<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;

class CrudCategoryController extends Controller
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

        $category = new Category;

        $category->title = $request->title;

        $category->save();
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
    public function insertCategory()
    {

        return view('backend.insert_category');
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
    public function storeCategory(Request $request)
    {
        // Validate the request...

        $category = new Category;

        //$descriptions = new Description;

        $category->title = $request->title;

        //$descriptions->title = $request->descriptions;

        //$descriptions->save();

        $category->save();

        return redirect()->route('showCategory');

        // $goods = Goods::all();

        // return view('welcome', ["goods" => $goods]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showCategory()
    {
        $categories = Category::all();

        return view('backend.show_category', ["categories" => $categories]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editCategory($id)
    {
        $category = Category::find($id);

        return view('backend.edit_category', ["category" => $category]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditCategory(Request $request)
    {
        $category = Category::find($request->id);

        $category->title = $request->title;

        $category->save();

        return redirect()->route('showCategory');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowCategory(Request $request)
    {
        // $id = $request->id; 
        // `echo $id >>/tmp/qaz`;
        $id = $request->id;
        $del_desc = $request->del_desc;

        $category = Category::find($id)->delete();

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