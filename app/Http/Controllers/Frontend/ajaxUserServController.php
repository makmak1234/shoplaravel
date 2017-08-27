<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

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

    public function ajaxBagUserServAction($id, $size = '0', $color = '0', $bagreg, $request)
    {
    	$myecho = json_encode(" id=".$id."size=".$size."color=".$color."bagreg=".$bagreg);
        `echo " ajaxBagUserServAction    " >>/tmp/qaz`;
        `echo "$myecho" >>/tmp/qaz`;
        // //exit;

    	$flag = false;

    	if($request !== null){
            $session = $request->session();
        } 
        else{$session = null;}
        
    	//$session = $request->session();
        
		if($session !== null){//($session->get('idbasketsmall') != null){//
			$this->idarr = $session->idbasketsmall;
			$this->sizearr = $session->sizearr;
			$this->colorarr = $session->colorarr;
			$this->nid = $session->nid;
			$this->bigBagDisp = 'block';
		}

		if($id > 0){ //if(isset($_GET["id"])){
			$clearone = $request->mclon;//$mclon;
			$this->bigBagDisp = 'block';
			//наличие значения в массиве
				if($bagreg == true){
					foreach($this->idarr as $k=>$v){
						if($v == $id && $this->sizearr[$k] == $size  && $this->colorarr[$k] == $color){
							$flag = true;
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
					if (!$flag) {
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

			$em = $this->entityManager;

        	//$repository = $em->getRepository('AdminBundle:childrenGoods');

			foreach ($this->idarr as $key => $value) {
	        	$query = App\Goods::find($value);
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
					$this->sizeTitle[$k] = $tmp_size[$this->sizearr[$k]]->title;//$this->childrenGoods[$k]->getChildrenGoodsSizeNumber()->get($this->sizearr[$k])->getSize()->getSize();
				}
				else{
					$this->sizeTitle[$k] = '';
				}
				

				if ($this->colorarr[$k] != 'undefined') {

					//foreach ($good->size as $s)
                            $goodsSizes = App\GoodsSizes::find($tmp_size[$this->sizearr[$k]]->id);//App\GoodsSizes::where('id', $s->pivot->id)->get(); 
                                   	$goodSize = $goodsSizes[0];
                           
                        
                                //foreach ($goodSize->color as $col)
                                   	$tmp_goodSizeColor = $goodSize->color;
                                   	$this->colorTitle[$k] = $tmp_goodSizeColor[$this->colorarr[$k]]->title;
                                   	//$col->title;
                                                                           
                          
                                //foreach ($goodSize->color as $col)
                         
                                    $pict = App\Picture::find($tmp_goodSizeColor[$this->colorarr[$k]]->pivot->pictures_id);
                                    
                                    $this->pathImages[$k] = asset('storage/' . $pict[0]->path);
                                    

					// $this->colorTitle[$k] = $this->childrenGoods[$k]->getChildrenGoodsSizeNumber()->get($this->sizearr[$k])->getChildrenGoodsColorNumber()->get($this->colorarr[$k])->getColor()->getColor();
					// $this->pathImages[$k] = $this->childrenGoods[$k]->getChildrenGoodsSizeNumber()->get($this->sizearr[$k])->getChildrenGoodsColorNumber()->get($this->colorarr[$k])->getImage()->getPath();
				}
				else{
					$this->colorTitle[$k] = '';
					$this->pathImages[$k] = '';
				}
			}
		}
		else{
			//destroy_session_and_data();
			session_destroy();//$session->flush();
			$this->bigBagDisp = 'none';
		}
		$this->size = $size;
		$this->color = $color;
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