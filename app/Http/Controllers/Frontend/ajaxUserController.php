<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\ajaxUserServController;
use Illuminate\Http\Request;

/**
 * indexUserController controller.
 *
 * 
 */
class ajaxUserController extends Controller
{

    /**
     * The user repository instance.
     */
    protected $ajaxUserServ;

    public function __construct(ajaxUserServController $ajaxUserServ){
        $this->ajaxUserServ = $ajaxUserServ;
    }

    /**
     * Lists all childrenGoods entities.
     *
     * @Route("/ajax_bag_user/{id}", name="ajax_bag_user", requirements={"id": ".*\d+"})
     * @Method("GET")
     */
    public function ajaxBagUserAction($id, $bagreg = true, Request $request = null)
    {

        //$ajaxUserServ = $this->get('ajax.user.serv');


        if($request !== null){
            $size = $request->size;
        } 
        else{$size = 0;}

        if($request !== null){
            $color = $request->color;
        } 
        else{$color = 0;}

        // $myecho = json_encode($size);
        // `echo " size    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // //exit;

        // $myecho = json_encode($color);
        // `echo " color    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // //exit;

        // $myecho = json_encode(" id=".$id." size=".$size." color=".$color." bagreg=".$bagreg);
        // `echo " ajaxBagUserAction    " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;
        // //exit;

        $this->ajaxUserServ->ajaxBagUserServAction($id, $size, $color, $bagreg, $request);

        // $myecho = json_encode($this->ajaxUserServ->getSizearr());
        // `echo " bigBag  sizearr  " >>/tmp/qaz`;
        // `echo "$myecho" >>/tmp/qaz`;

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
            ]);
    }

    /**
     * Lists all childrenGoods entities.
     *
     * @Route("/ajax_checkout_user/{id}", name="ajax_checkout_user", requirements={"id": ".*\d+"})
     * @Method("GET")
     */
    public function ajaxCheckoutUserAction($id, $bagreg = true, Request $request)
    {
        $sourcePath = array();

        //$ajaxUserServ = $this->get('ajax.user.serv');

        $size = $request->size;
        if ($size == null) {
        	$size = 0;
        }

        $color = $request->color;
        if ($color == null) {
        	$color = 0;
        }

        $this->ajaxUserServ->ajaxBagUserServAction($id, $size, $color, $bagreg, $request);

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
            'sourcePath' => $this->sourcePath,//$ajaxUserServ->getPathImages(),
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

    	$session = $request->getSession();
    	
	    $nidaj = $request->query->get('nidaj');

		$k = $request->query->get('kg2');

		$nid = $session->get('nid');

		$nid[$k] = $nidaj;

		$session->set('nid', $nid);

		return new Response();
	}

}