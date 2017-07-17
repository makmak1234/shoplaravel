<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public $timestamps = false;
	
    /**
     * The Goods that belong to the Size.
     */
    public function colorGoodsSize()
    {
        return $this->hasMany('App\ColorGoodsSize');
    }
}
