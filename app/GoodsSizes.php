<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsSizes extends Model
{
   /**
     * The Goods that belong to the Size.
     */
    public function color()
    {
        return $this->belongsToMany('App\Color', 'color_goods_sizes', 'goods_sizes_id', 'colors_id')->withPivot('pictures_id');
    }
}
