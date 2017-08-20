<?php

namespace App\Http\Controllers\Frontend;

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
//use Intervention\Image\ImageManager;
//use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function index()
    {
        $goods = Goods::all();

        $pictures = Picture::all();

        $categories = Category::all();
        $subcats = Subcategory::all();

        $category_subcats = CategorySubcat::all();

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

        return view('frontend.index', ["goods" => $goods, "pictures" => $pictures, "categories" => $categories, "subcats" => $subcats, "category_subcats" => $category_subcats]);//, "goodsSizes" => $goodsSizes
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function catSubcatShow()
    {
    	
    }


}