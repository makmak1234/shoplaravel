<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\ajaxUserServController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * indexUserController controller.
 *
 * 
 */
class ajaxUserController extends Controller
{
    private $language;

    /**
     * The user repository instance.
     */
    protected $ajaxUserServ;

    public function __construct(ajaxUserServController $ajaxUserServ, Request $request){
        $this->ajaxUserServ = $ajaxUserServ;
        $this->language = $request->cookie('language') ?? 'en';
        App::setLocale($this->language);
    }

    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function ajaxBagUserAction($id, $bagreg = 1, Request $request = null)
    {
        //$ajaxUserServ = $this->get('ajax.user.serv');

        // $size = $request->size;
        // if ($size == null) {
        //     $size = 0;
        // }

        // $color = $request->color;
        // if ($color == null) {
        //     $color = 0;
        // }

//        $myecho = json_encode($request);
//        `echo " bigBag  request  " >>/tmp/qaz`;
//        `echo "$myecho" >>/tmp/qaz`;

        if($request != null){
            $size = $request->size;
        } 
        else{$size = 0;}

        if($request != null){
            $color = $request->color;
        } 
        else{$color = 0;}
        

        $this->ajaxUserServ->ajaxBagUserServAction($id, $size, $color, $bagreg, $this->language, $request);

        return view('frontend.bigBag', 
            ["goods" => $this->ajaxUserServ->getChildrenGoods(), 
            'id' => $id,
            'idarr' => $this->ajaxUserServ->getIdarr(),
            'sizearr' => $this->ajaxUserServ->getSizearr(),
            'colorarr' => $this->ajaxUserServ->getColorarr(),
            'priceone' => $this->ajaxUserServ->getPriceone(),
            'priceall' => $this->ajaxUserServ->getPriceall(),
            'bigBagDisp' => $this->ajaxUserServ->getBigBagDisp(),
            'nid' => $this->ajaxUserServ->getNid(),
            'nidAll' => $this->ajaxUserServ->getNidAll(),
            'sizeTitle' => $this->ajaxUserServ->getSizeTitle(),
            'colorTitle' => $this->ajaxUserServ->getColorTitle(),
            'language' => $this->language,
            ]);
    }

    /**
     * Lists all childrenGoods entities.
     *
     * @Route("/ajax_checkout_user/{id}", name="ajax_checkout_user", requirements={"id": ".*\d+"})
     * @Method("GET")
     */
    public function ajaxCheckoutUserAction($id, $bagreg = 1, Request $request = null) //$bagreg = 1
    {
        $myecho = json_encode($request);
        `echo " ajax_checkout_user  request  " >>/tmp/qaz`;
        `echo "$myecho" >>/tmp/qaz`;
//
//        $myecho = json_encode($id);
//        `echo " ajax_checkout_user  id  " >>/tmp/qaz`;
//        `echo "$myecho" >>/tmp/qaz`;
        
        $sourcePath = array();

        //$ajaxUserServ = $this->get('ajax.user.serv');

        if($request != null){
            $size = $request->size;
            // if ($size == null) {
            // 	$size = 0;
            // }
        }else{
           $size = 0; 
        }

        if($request != null){
            $color = $request->color;
            // if ($color == null) {
            // 	$color = 0;
            // }
        }else{
            $color = 0;
        }

        
        $this->ajaxUserServ->ajaxBagUserServAction($id, $size, $color, $bagreg, $this->language, $request);

        //$cacheManager = $this->container->get('liip_imagine.cache.manager');

        foreach($this->ajaxUserServ->getPathImages() as $indImag => $pathImag){
            $pathImg = $pathImag . '50_50.jpg';
            $sourcePath[] = $pathImg;//$cacheManager->getBrowserPath($pathImg, 'my_thumb_cart');
        }

        return view('frontend.checkoutBag', 
            ['childrenGoods' => $this->ajaxUserServ->getChildrenGoods(),
            'id' => $id,
            'idarr' => $this->ajaxUserServ->getIdarr(),
            'sizearr' => $this->ajaxUserServ->getSizearr(),
            'colorarr' => $this->ajaxUserServ->getColorarr(),
            'priceone' => $this->ajaxUserServ->getPriceone(),
            'priceall' => $this->ajaxUserServ->getPriceall(),
            'bigBagDisp' => $this->ajaxUserServ->getBigBagDisp(),
            'nid' => $this->ajaxUserServ->getNid(),
            'sizeTitle' => $this->ajaxUserServ->getSizeTitle(),
            'colorTitle' => $this->ajaxUserServ->getColorTitle(),
            'sourcePath' => $sourcePath,//$ajaxUserServ->getPathImages(),
            'language' => $this->language,
        ]);
    }

    /**
     * Lists all childrenGoods entities.
     *
     * @Route("/basket_big_change", name="basket_big_change")
     * @Method("GET")
     */
    public function basketBigChangeAction(Request $request)
    {

    	$session = $request->session();
    	
	    $nidaj = $request->nidaj;

		$k = $request->kg2;

		$nid = $session->get('nid');

		$nid[$k] = $nidaj;

		$session->put('nid', $nid);

		// return new Response();
        return;
	}

}