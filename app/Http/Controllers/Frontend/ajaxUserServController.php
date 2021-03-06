<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Goods;
//use App\Description;
//use App\Category;
//use App\Subcategory;
//use App\Size;
//use App\Color;
use App\GoodsSizes;
//use App\ColorGoodsSizes;
//use App\CategorySubcat;
use App\Picture;
use Illuminate\Http\Request;


/**
 * indexUserController controller.
 *
 * 
 */
class ajaxUserServController extends Controller
{
	private $idarr = array();
	private $sizearr = array();
	private $colorarr = array();
	private $nid = array();
	private $nidAll = 0;
	private $priceall = 0;
	private $bigBagDisp = 'none';
	private $childrenGoods = array();
	private $priceone = array();
	private $entityManager;
	private $sizeTitle = array();
	private $colorTitle = array();
	private $pathImages = array();

 //    public function __construct($entityManager) {
	//     $this->entityManager = $entityManager;
	// }

    public function ajaxBagUserServAction($id, $size = '0', $color = '0', $bagreg, $language, $request)
    {
//    	$myecho = json_encode($request);
//        `echo " ajax_checkout_user  request  " >>/tmp/qaz`;
        `echo "ajaxBagUserServAction $language" >>/tmp/qaz`;

    	$flag = 0;

       	if($request != null){
       		$session = $request->session();
       	}else{
            $session = null;
        }
    	  
			if(!empty(session('idbasketsmall'))) {//($session->get('idbasketsmall', false)) {
				$this->idarr = session('idbasketsmall');//$session->get('idbasketsmall');

	            if(count($this->idarr)>0){
		        }else{
		        }

				$this->sizearr = session('sizearr');//$session->get('sizearr');
				$this->colorarr = session('colorarr');//$session->get('colorarr');
				$this->nid = session('nid');//$session->get('nid');
				$this->bigBagDisp = 'block';
			}

		if($id > 0){ //if(isset($_GET["id"])){
			$clearone = $request->mclon;//$mclon;
			$this->bigBagDisp = 'block';
			//наличие значения в массиве
				if($bagreg == 1){
					foreach($this->idarr as $k=>$v){
						if($v == $id && $this->sizearr[$k] == $size  && $this->colorarr[$k] == $color){
							$flag = 1;
    						if($clearone == 'false'){
								$this->nid[$k]++;
							}
							else{
									array_splice($this->idarr, $k, 1);//;unset($idarr[$k])
									array_splice($this->sizearr, $k, 1);
									array_splice($this->colorarr, $k, 1);
									array_splice($this->nid, $k, 1);//;unset($nid[$k])
									break;
							}
						}	
					}
					if ($flag == 0) {
						$this->idarr[] = $id;
						$this->sizearr[] = $size;
						$this->colorarr[] = $color;
						$this->nid[] = 1;
					}
				}

			if(count($this->idarr) == 0) $id= -1;	
		}

		if (!($id == -1)){
			session(['idbasketsmall'=>$this->idarr]);// $session->set('idbasketsmall', $this->idarr);
			session(['sizearr'=>$this->sizearr]);// $session->set('sizearr', $this->sizearr);
			session(['colorarr'=>$this->colorarr]);// $session->set('colorarr', $this->colorarr);
			session(['nid'=>$this->nid]);// $session->set('nid', $this->nid);

			foreach ($this->idarr as $key => $value) {
	        	$query = Goods::find($value);
	        	$this->childrenGoods[] = $query;
	        }
	    
	        foreach($this->idarr as $k=>$v){
				$n = $this->nid[$k];
				$row = 100;//$this->childrenGoods[$k]->getPriceGoods()->getRub();
				$this->priceone[$k] = $row * $n;
				$this->priceall += $this->priceone[$k];
				$this->nidAll += $n;
				
				if ($this->sizearr[$k] != 'undefined') {
					$tmp_size = $this->childrenGoods[$k]->size;
					$this->sizeTitle[$k] = $tmp_size[$this->sizearr[$k]]->$language;//$this->childrenGoods[$k]->getChildrenGoodsSizeNumber()->get($this->sizearr[$k])->getSize()->getSize();
				}
				else{
					$this->sizeTitle[$k] = '';
				}

				if ($this->colorarr[$k] != 'undefined') {

                            $goodsSizes = GoodsSizes::find($tmp_size[$this->sizearr[$k]]->pivot->id);//App\GoodsSizes::where('id', $s->pivot->id)->get(); 
                                   	$goodSize = $goodsSizes;

                                   	$tmp_goodSizeColor = $goodSize->color;
                                   	$this->colorTitle[$k] = $tmp_goodSizeColor[$this->colorarr[$k]]->$language;
                         
                                    $pict = Picture::find($tmp_goodSizeColor[$this->colorarr[$k]]->pivot->pictures_id);
                                    
                                    $this->pathImages[$k] = asset('storage/' . $pict->path);
				}
				else{
					$this->colorTitle[$k] = '';
					$this->pathImages[$k] = '';
				}
			}
		}
		elseif($session != null){
			$session->flush();
			$this->bigBagDisp = 'none';
		}
		$this->size = $size;
		$this->color = $color;

		`echo "                                                                                         " >>/tmp/qaz`;
    }

    public function getIdarr(){
    	return $this->idarr;
    }

    public function getSizearr(){
    	return $this->sizearr;
    }

    public function getColorarr(){
    	return $this->colorarr;
    }

    public function getNid(){
    	return $this->nid;
    }

    public function getNidAll(){
    	return $this->nidAll;
    }

    public function getPriceall(){
    	return $this->priceall;
    }

    public function getBigBagDisp(){
    	return $this->bigBagDisp;
    }

    public function getChildrenGoods(){
    	return $this->childrenGoods;
    }

    public function getPriceone(){
    	return $this->priceone;
    }

	public function getSizeTitle(){
    	return $this->sizeTitle;
    }

    public function getColorTitle(){
    	return $this->colorTitle;
    }

    public function getPathImages(){
    	return $this->pathImages;
    }

}