<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
	public $timestamps = false;
	
    /**
     * The Goods that belong to the Size.
     */
    public function goodsSize()
    {
        return $this->belongsToMany('App\GoodsSize', 'color_goods_sizes', 'colors_id', 'goods_sizes_id')->withPivot('pictures_id');
    }
}
