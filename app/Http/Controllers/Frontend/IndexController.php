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
    public function catSubcatShow($cat_id, $subcat_id)
    {
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

        //$categories = Category::all();
        //$subcats = Subcategory::all();

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

        return view('frontend.subcat', ["goods" => $goods, "picts" => $picts]);//, "goodsSizes" => $goodsSizes
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function goodShow($cat_id, $subcat_id, $id)
    {
        $good = Goods::where([
              ['id', '=', $id],
          ])->get();

        $good = $good[0]; 

        return view('frontend.good', ["good" => $good]);
    }


    public function smallBagAction(Request $request = null)
    {
        //$nidAll = $request->query->get('nidAll');
        if($request !== null){
            $session = $request->session();
        }
        else{$session = null;}

        $nidAll = 0;
        if ($session !== null) {
            $nid = $session->nid;
            foreach ($nid as $key => $value) {
                $nidAll += $value;
            }
        }

        return view('frontend.smallBag', ['nidAll' => $nidAll]);
    }


    /**
     * Creates a new childrenGoods entity.
     *
     * @Route("/bag_register", name="bag_register")
     * @Method({"GET", "POST"})
     */
    public function bagRegisterAction(Request $request)
    {
        //$session = new Session();
        $session = $request->getSession();

        $bagRegister = new bagRegister;

        $bagRegister->setRegDatetime(new \DateTime('now'));
        $token = "qwerty";

        if($session->get('bagRegister') != null){
            $bagRegisterSession = $session->get('bagRegister');
            $token = $session->get('token');
            $bagRegister->setName($bagRegisterSession->getName());
            $bagRegister->setCity($bagRegisterSession->getCity());
            $bagRegister->setTel($bagRegisterSession->getTel());
            $bagRegister->setComment($bagRegisterSession->getComment());
            
            //$session-> invalidate();
        }

        $form = $this->createForm('UserBundle\Form\bagRegisterType', $bagRegister);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($_POST["back_shop"] == 'true'){
                $back_shop = $_POST["back_shop"];
                $session->set('bagRegister', $bagRegister);

                print "_token ";
                var_dump($_POST["bag_register"]["_token"]);

                $session->set('token', $_POST["bag_register"]["_token"]);
                
                return $this->redirectToRoute('index_user');
            }

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $query = $em->createQuery(//WHERE p.orderclient = max(p.orderclient)
                    'SELECT max(p.orderclient)
                    FROM UserBundle:bagRegister p
                    '
                );

                $orderclientmax = $query->getResult();//->getOrderclient();

                //print_r('orderclientmax: ');
                //print_r($orderclientmax[0][1]); print_r('<br>');

                //$bagRegister->setOrderclient($orderclientmax + 1);//select max(age) from person
                if($orderclientmax[0][1] < 283758){
                 $bagRegister->setOrderclient(283758);
                }
                else{
                $bagRegister->setOrderclient($orderclientmax[0][1] + 1);
                }

                $repository = $em->getRepository('AdminBundle:childrenGoods');

                $idarr = $session->get('idbasketsmall');
                $nid = $session->get('nid');
                $sizearr = $session->get('sizearr');
                $colorarr = $session->get('colorarr');
                $priceall = 0;

                foreach($idarr as $k=>$v){
                    $buyClients = new buyClients;
                    $childrenGoods = $repository->find($v);
                    $priceone[] = $childrenGoods->getPriceGoods()->getRub();
                    $pricegoods[] = $priceone[$k] * $nid[$k];
                    $priceall += $pricegoods[$k];

                    if ($sizearr[$k] != 'undefined') {
                        $sizeTitle[] = $childrenGoods->getChildrenGoodsSizeNumber()->get($sizearr[$k])->getSize()->getSize();
                    }
                    else{
                        $sizeTitle[] = '';
                    }
                    

                    if ($colorarr[$k] != 'undefined') {
                        $colorTitle[] = $childrenGoods->getChildrenGoodsSizeNumber()->get($sizearr[$k])->getChildrenGoodsColorNumber()->get($colorarr[$k])->getColor()->getColor();
                    }
                    else{
                        $colorTitle[] = '';
                    }

                    $valuta = '';//?????

                    $buyClients->setSize($sizeTitle[$k]);
                    $buyClients->setColor($colorTitle[$k]);
                    $buyClients->setNid($nid[$k]);
                    $buyClients->setPriceone($priceone[$k]);

                    $buyClients->setBagRegister($bagRegister);
                    $buyClients->setChildrenGoods($childrenGoods);

                    //$em->persist($bagRegister);
                    $em->persist($buyClients);

                    //отправка email
                    $name = $bagRegister->getName();
                    $order = $bagRegister->getOrderclient();
                    $tel = $bagRegister->getTel();
                    $email = $bagRegister->getEmail();
                    $city = $bagRegister->getCity();
                    $title[] = $childrenGoods->getTitle();
                        
                }

                $em->persist($bagRegister);
                $em->flush();

                $comment = $bagRegister->getComment();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Покупки одежды')
                    ->setFrom('send@example.com')
                    ->setTo('qwertyfamiliya@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'UserBundle::emailAdmin.html.twig',
                            array('name' => $name,
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
                                )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);
                //end email 

                $session-> invalidate();

                return $this->render('UserBundle::thanks.html.twig', array(
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
                ));
            }
        }

        if($request->query->get('id')){
            $id = $request->query->get('id');
        }
        else{
            $id = 0;
        }
        
        return $this->render('UserBundle::bagRegister.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
            'mytest' => "mycity",
            'id' => $id,
        ));
    }
/**
     *
     *
     * @Route("/thanks", name="thanks")
     * @Method("GET")
     */
    public function thanksAction()
    {
        return $this->render('UserBundle::thanks.html.twig', array(
            //'childrenGood' => $childrenGood,
            //'delete_form' => $deleteForm->createView(),
            //s'add_new_cat' => $add_new_cat,
        ));
    }


}