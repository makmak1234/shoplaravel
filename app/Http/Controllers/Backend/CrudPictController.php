<?php

namespace App\Http\Controllers\Backend;

use App\ColorGoodsSize;
use App\Color;
use App\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


//use Illuminate\Support\Facades\DB;

class CrudPictController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function insertPict()
    {

        return view('backend.insert_pict');
    }

    public function writeValidPict()
    {

        return view('backend.write_pict');
    }

    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storePict(Request $request)
    {
        // Validate the request...

        $pict = new Picture;

        $path = $request->file('pict')->store('pictures');
        //$path = Storage::putFile('pictures', $request->file('pict'));

        // $myecho = json_encode($path);
        // `echo " request->file    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // exit;

        $img = Image::make(asset('storage/' . $path))->resize(50, 50);
        $img->save(public_path('storage/' .  $path . '50_50.jpg' ));

        $pict->path = $path;

        $pict->save();

        return redirect()->route('showPict');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function showPict()
    {
        $picts = Picture::all();

        return view('backend.show_pict', ["picts" => $picts, "nocache" => rand()]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function editPict($id)
    {
        $pict = Picture::find($id);

        return view('backend.edit_pict', ["pict" => $pict]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function storeEditPict(Request $request)
    {
        $pict = Picture::find($request->id);

        //str_replace('pictures/', '', $pict->path);
        // $contents = $request->file('pict');
        // $myecho = json_encode($contents);
        // `echo " request->file    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        //exit;

        //$path = $request->file('pict')->storeAs('pictures', str_replace('pictures/', '', $pict->path));
        $path = $request->file('pict')->storeAs('', $pict->path);

        $pict->path = $path;

        $pict->save();

        return redirect()->route('showPict');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function deleteRowPict(Request $request)
    {
        $id = $request->id;
        $del_desc = $request->del_desc;

        // $pict = Picture::find($id);
        // Storage::delete($pict->path);
        // exit;
        $pict = Picture::find($id);
        Storage::delete($pict->path);
        $pict->delete();

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


}