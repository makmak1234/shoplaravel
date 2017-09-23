<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class ColorGoodsSizes extends Model
{
	public $timestamps = false;
	
    /**
     * The Goods that belong to the Size.
     */
    public function picture()
    {
        return $this->belongsTo('App\Picture', 'pictures_id');
    }
}
