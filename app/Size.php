<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public $timestamps = false;
    
    /**
     * The Goods that belong to the Size.
     */
    public function goods()
    {
        return $this->belongsToMany('App\Goods');
    }
}
