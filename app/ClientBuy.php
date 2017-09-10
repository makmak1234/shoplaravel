<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientBuy extends Model
{
    public $timestamps = false;
    
    /**
     * Get the goods that owns the subcategory.
     */
    public function goods()
    {
        return $this->belongsTo('App\Goods', 'good_id');
    }

    /**
     * Get the goods that owns the subcategory.
     */
    public function clientRegistr()
    {
        return $this->belongsTo('App\ClientRegistr');
    }
}
