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
use App\ClientBuy;
use App\ClientRegistr;
// use App\Http\Controllers\Email\OrderController;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\App;
// use Validator;
//use Intervention\Image\ImageManager;
//use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    private $goods;
    private $pictures;
    private $categories;
    private $subcats;
    private $category_subcats;
    private $request;
 
    public function __construct(Request $request){
        $this->request = $request;
    }
    
    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);
        // Cache::flush();
        // exit;
        if (Cache::has('index_'.$language)) {
            return view('frontend.index', ["language" => $language]);
        }else{
            $this->index_data();

            return view('frontend.index', ["goods" => $this->goods, "pictures" => $this->pictures, "categories" => $this->categories, "subcats" => $this->subcats, "category_subcats" => $this->category_subcats, "language" => $language]);//, "goodsSizes" => $goodsSizes
        }
    }
    
    public function language($language="en")
    {
        App::setLocale($language);
        if (Cache::has('index_'.$language)) {
//            return view('frontend.index')->cookie('language', $language, 2592000);
            return response()
                ->view('frontend.index', ["language" => $language])->cookie('language', $language, 2592000);
        }else{
            $this->index_data();

            return response()
                ->view('frontend.index', ["goods" => $this->goods, "pictures" => $this->pictures, "categories" => $this->categories, "subcats" => $this->subcats, "category_subcats" => $this->category_subcats, "language" => $language])->cookie('language', $language, 2592000);
        }
    }
    
    public function index_data()
    {
        $this->goods = Goods::all();

        $this->pictures = Picture::all();

        $this->categories = Category::all();
        $this->subcats = Subcategory::all();

        $this->category_subcats = CategorySubcat::all();
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function catSubcatShow(Request $request, $cat_id, $subcat_id)
    {
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);
        
        $catSubcat = 'catSubcat_'.$language.$cat_id.'_'.$subcat_id;
        if (Cache::has($catSubcat)) {
            return view('frontend.subcat', ["catSubcat" => $catSubcat]);
        }else{

        	$goods = Goods::where([
                  ['categories_id', '=', $cat_id],
                  ['subcategories_id', '=', $subcat_id],
              ])->get();

            //$pictures = Picture::all();

            $picts = array();
            foreach ($goods as $good){
                foreach ($good->size as $s){
                    $goodsSizes = GoodsSizes::where('id', $s->pivot->id)->get();
                    foreach ($goodsSizes as $goodSize){
                        foreach ($goodSize->color as $col){
                            //if (!(in_array($col->id, $allcolor)))
                            $pict = Picture::where('id', $col->pivot->pictures_id)->get();
                            $picts[] = $pict[0]->path;
                        }
                    }
                }
            }

            $category_subcats = CategorySubcat::all();

            return view('frontend.subcat', ["goods" => $goods, "picts" => $picts, "catSubcat" => $catSubcat, "language" => $language]);//, "goodsSizes" => $goodsSizes
        }
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function goodShow(Request $request, $cat_id, $subcat_id, $id)
    {
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);
        
        $goodShow = 'good_'.$language.$cat_id.'_'.$subcat_id.'_'.$id;
        if (Cache::has($goodShow)) {
            return view('frontend.good', ["goodShow" => $goodShow]);
        }else{
            $good = Goods::where([
                  ['id', '=', $id],
              ])->get();

            $good = $good[0];

            return view('frontend.good', ["good" => $good, "goodShow" => $goodShow, "language" => $language]);
        }
    }


    public function smallBagAction()//(Request $request = null)
    {
        $language = $this->request->cookie('language') ?? 'en';
        App::setLocale($language);
        
        //$nidAll = $request->query->get('nidAll');

        // $myecho = json_encode($request);
        // `echo " smallBagAction  request  " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;

        // if($request !== null){
        //     $session = $request->session();
        // }
        // else{$session = null;}

        $nidAll = 0;
        if(!empty(session('nid'))) { //if ($session !== null) {
            $nid = session('nid');
            foreach ($nid as $key => $value) {
                $nidAll += $value;
            }
        }

        return view('frontend.smallBag', ['nidAll' => $nidAll, 'language' => $language]);
    }


    /**
     * Creates a new childrenGoods entity.
     *
     * @Route("/bag_register", name="bag_register")
     * @Method({"GET", "POST"})
     */
    public function bagRegisterAction(Request $request)
    {
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);

        $session = $request->session();

        //$bagRegister->setRegDatetime(new \DateTime('now'));
        $token = "qwerty";

        if($session->has('name')) {
            $name = $session->get('name');
            $city = $session->get('city');
            $tel = $session->get('tel');
            $comment = $session->get('comment');
            $token = $session->get('token');
        }else{
            $name = null;
            $city = null;
            $tel = null;
            $comment = null;
            $token = null;
        }

        // $form = $this->createForm('UserBundle\Form\bagRegisterType', $bagRegister);
        // $form->handleRequest($request);



        if($request->has('id')){
            $id = $request->id;
        }
        else{
            $id = 0;
        }

        return view('frontend.bagRegister', [
            'name' => $name,
            'city' => $city,
            'tel' => $tel,
            'comment' => $comment,
            'token' => $token,
            // 'form' => $form->createView(),
            // 'mytest' => "mycity",
            'id' => $id,
            'language' => $language,
        ]);
    }

    /**
     * Creates a new childrenGoods entity.
     *
     * @Route("/bag_register", name="bag_register")
     * @Method({"GET", "POST"})
     */
    public function bagRegisterStore(Request $request){
        
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);

        $session = $request->session();

        $session->put('name', $request->input('name'));
        $session->put('city', $request->input('city'));
        $session->put('tel', $request->input('tel'));
        $session->put('comment', $request->input('comment'));
        $session->put('token', $request->input('token'));

        if($request->input('back_shop') == 'true'){ //($_POST["back_shop"] == 'true'){
            $back_shop = $request->input('back_shop'); //$_POST["back_shop"];

            //$request->session()->put('token', $_POST["bag_register"]["_token"]);

            return redirect()->route('index');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:20|alpha_dash|nullable',
            'city' => 'max:20|alpha_dash|nullable',
            'tel' => "required|between:9,13|regex:'^[0-9+()]+$'",
            'comment' => 'max:190|nullable',
        ]);

        if ($validator->fails()) {
            return redirect('bag_register_secure')
                        ->withErrors($validator)
                        ->withInput();
        }


        $bagRegister = new ClientRegistr;

        $myecho = json_encode($request);
        `echo " bagRegisterStore  request  " >>/tmp/qaz`;
        `echo "$myecho" >>/tmp/qaz`;

        //if ($form->isSubmitted()) {


            // if ($form->isValid()) {
                //$em = $this->getDoctrine()->getManager();

                // $query = $em->createQuery(
                //     'SELECT max(p.orderclient)
                //     FROM UserBundle:bagRegister p
                //     '
                // );

                $orderclientmax = DB::table('client_registrs')->max('orderclient');

                // $myecho = json_encode($orderclientmax[0][1]);//??????????????????????????????????
                // `echo " bagRegisterStore  orderclientmax  " >>/tmp/qaz`;
                // `echo "$myecho" >>/tmp/qaz`;

                if($orderclientmax < 283758){//(empty($orderclientmax) or $orderclientmax == null){
                    $bagRegister->orderclient = 283758;
                }else{
                    $bagRegister->orderclient = $orderclientmax + 1;
                }

                $bagRegister->name = $request->input('name');
                $bagRegister->city = $request->input('city');
                $bagRegister->tel = $request->input('tel');
                $bagRegister->email = "email_dummy";
                $bagRegister->comment = $request->input('comment');

                $bagRegister->save();

                //$repository = new Goods;//$em->getRepository('AdminBundle:childrenGoods');

                $idarr = $session->get('idbasketsmall');
                $nid = $session->get('nid');
                $sizearr = $session->get('sizearr');
                $colorarr = $session->get('colorarr');
                $priceall = 0;

                foreach($idarr as $k=>$v){
                    $buyClients = new ClientBuy;
                    $childrenGoods = Goods::find($v);
                    $priceone[] = 100;//$childrenGoods->getPriceGoods()->getRub();
                    $pricegoods[] = $priceone[$k] * $nid[$k];
                    $priceall += $pricegoods[$k];

                    if ($sizearr[$k] != 'undefined') {
                        $tmp_size = $childrenGoods->size;
                        $sizeTitle[] = $tmp_size[$sizearr[$k]]->$language;
                        //$sizeTitle[] = $childrenGoods->getChildrenGoodsSizeNumber()->get($sizearr[$k])->getSize()->getSize();
                    }
                    else{
                        $sizeTitle[] = '';
                    }


                    if ($colorarr[$k] != 'undefined') {
                        $goodSize = GoodsSizes::find($tmp_size[$sizearr[$k]]->pivot->id);
                        $tmp_goodSizeColor = $goodSize->color;
                        $colorTitle[$k] = $tmp_goodSizeColor[$colorarr[$k]]->$language;
                        //$colorTitle[] = $childrenGoods->getChildrenGoodsSizeNumber()->get($sizearr[$k])->getChildrenGoodsColorNumber()->get($colorarr[$k])->getColor()->getColor();
                    }
                    else{
                        $colorTitle[] = '';
                    }

                    $valuta = 'rub';//?????

                    $buyClients->size = $sizeTitle[$k];
                    $buyClients->color = $colorTitle[$k];
                    $buyClients->nid = $nid[$k];
                    $buyClients->priceone = $priceone[$k];
                    $buyClients->valuta = $valuta;

                    $buyClients->clientRegistr()->associate($bagRegister);
                    $buyClients->goods()->associate($childrenGoods);

                    $buyClients->save();
                    //$em->persist($buyClients);

                    //отправка email
                    $title[] = $childrenGoods->$language;

                }


                // $em->persist($bagRegister);
                // $em->flush();
                $name = $bagRegister->name;
                $order = $bagRegister->orderclient;
                $tel = $bagRegister->tel;
                $email = $bagRegister->email;
                $city = $bagRegister->city;
                $comment = $bagRegister->comment;

                // $orderShipped = new OrderShipped;// OrderController;
                // $orderShipped->name = $name;
                // $orderShipped->order = $order;
                // $orderShipped->tel = $tel;
                // $orderShipped->email = $email;
                // $orderShipped->city = $city;
                // $orderShipped->pricegoods = $pricegoods;
                // $orderShipped->priceall = $priceall;
                // $orderShipped->comment = $comment;

                Mail::to('qwertyfamiliya@gmail.com')->send(new OrderShipped($name, $order, $title, $tel, $email, $city, $pricegoods, $priceall, $comment, $sizeTitle, $colorTitle, $nid, $priceone));

                // $message = \Swift_Message::newInstance()
                //     ->setSubject('Покупки одежды')
                //     ->setFrom('send@example.com')
                //     ->setTo('qwertyfamiliya@gmail.com')
                //     ->setBody(
                //         $this->renderView(
                //             'UserBundle::emailAdmin.html.twig',
                //             array('name' => $name,
                //                     'order' => $order,
                //                     'tel' => $tel,
                //                     'email' => $email,
                //                     'city' => $city,
                //                     'title' => $title,
                //                     'sizeTitle' => $sizeTitle,
                //                     'colorTitle' => $colorTitle,
                //                     'nid' => $nid,
                //                     'priceone' => $priceone,
                //                     'pricegoods' => $pricegoods,
                //                     'comment' => $comment,
                //                     'priceall' => $priceall,
                //                 )
                //         ),
                //         'text/html'
                //     );

                // $this->get('mailer')->send($message);
                //end email

                $session->flush();

                return view('frontend.thanks', [
                'name' => $name,
                'order' => $order,
                'tel' => $tel,
                'email' => $email,
                'city' => $city,
                'title' => $title,
                'sizeTitle' => $sizeTitle,
                'colorTitle' => $colorTitle,
                'nid' => $nid,
                'priceone' => $priceone,
                'pricegoods' => $pricegoods,
                'comment' => $comment,
                'priceall' => $priceall,
                'language' => $language,
                ]);
            // }
        //}
    }

    /**
     *
     *
     * @Route("/thanks", name="thanks")
     * @Method("GET")
     */
    public function thanksAction(Request $request)
    {
        $language = $request->cookie('language') ?? 'en';
        App::setLocale($language);
        
        return view('frontend.thanks', [
            "language" => $language
            //'childrenGood' => $childrenGood,
            //'delete_form' => $deleteForm->createView(),
            //s'add_new_cat' => $add_new_cat,
        ]);
    }


}
