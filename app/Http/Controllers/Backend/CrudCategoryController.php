<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;

class CrudCategoryController extends Controller
{

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

        $category->title = $request->title;

        // $myecho = json_encode($request->file('pict'));
        // `echo " request->file    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;

        $path = $request->file('pict')->store('pict_cat');
        //$path = Storage::putFile('pictures', $request->file('pict'));

        $img = Image::make(asset('storage/' . $path))->resize(null, 100, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(public_path('storage/' .  $path . '50_50.jpg' ));

        $category->path = $path;

        $category->save();
        Cache::flush();

        return redirect()->route('showCategory');
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

        // if (Storage::disk('local')->exists(asset('storage/' . $category->path))) {
            // $myecho = json_encode('yes');
            // `echo " category->path    " >>/tmp/qaz`;
            // `echo "$myecho" >>/tmp/qaz`;
            // exit;
            // Storage::delete(asset('storage/' . $category->path));
        // }

        if(!empty($category->path)){
            $path = $request->file('pict')->storeAs('', $category->path);
        }
        else{
            $path = $request->file('pict')->store('pict_cat'); 
        }


        $img = Image::make(asset('storage/' . $path))->resize(null, 100, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(public_path('storage/' .  $path . '50_50.jpg' ));

        $category->path = $path;

        $category->save();
        Cache::flush();

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

        $category = Category::find($id);

        Storage::delete($category->path);
        Storage::delete($category->path . '50_50.jpg');

        $category->delete();
        Cache::flush();

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