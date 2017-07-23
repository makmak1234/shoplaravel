<?php

namespace App\Http\Controllers\Backend;

use App\Goods;
use App\Description;
use App\Size;
use App\Color;
use App\GoodsSizes;
use App\ColorGoodsSizes;
use App\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
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

        $sizes = Size::all();

        $colors = Color::all();

        $pictures = Picture::all();

        //$manager = new ImageManager(array('driver' => 'imagick'));

        return view('backend.insert_tables', ["descrs" => $descrs, "sizes" => $sizes, "colors" => $colors, "pictures" => $pictures]);//
    }

    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeTables(Request $request)
    {
        // Validate the request...

        // $myecho = json_encode($request->pict_radio[1]);
        // `echo " request->pict_radio:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;

        $goods = new Goods;
        $goods->title = $request->title;
        $goods->descriptions()->associate($request->descriptions);//($descriptions);
        $goods->save();
        $goods->size()->attach($request->size);

        $goods->save();

        $goodsSizes = GoodsSizes::where('goods_id', $goods->id)->get();
        $colors = $request->color;
        foreach ($goodsSizes as $goodSize) {
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

        return redirect()->route('showTables');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showTables()
    {
        $goods = Goods::all();

        $pictures = Picture::all();

        //$goodsSizes = GoodsSizes::where('goods_id', '13')->get();

        //$colors = Color::where('id', '3')->get();

        // $myecho = json_encode($colors);
        // `echo " colors:    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // //exit;

        return view('welcome', ["goods" => $goods, "pictures" => $pictures]);//, "goodsSizes" => $goodsSizes
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
              }                                           
            }
        }

        // $myecho = json_encode($curszs);
        // $myecho2 = json_encode($curclrs);
        //     `echo " curszs:    " >>/tmp/qaz`;
        //     `echo "$myecho" >>/tmp/qaz`;
        //     `echo " curclrs:    " >>/tmp/qaz`;
        //     `echo "$myecho2" >>/tmp/qaz`;
        // exit;

        return view('backend.edit_tables', ["good" => $good, "descrs" => $descrs, "sizes" => $sizes, "colors" => $colors, "curszs" => $curszs, "curclrs" => $curclrs, "pictures" => $pictures]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditTables(Request $request)
    {
        $goods = Goods::find($request->id)->delete();

        $this->storeTables($request);

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
            $descriptions->delete();
            return response()->json(["success" => true, "message" => "Запись и описание удалены"]);
        }

        $good->delete();
        
        return response()->json(["success" => true, "message" => "Запись удалена"]);
    }

}