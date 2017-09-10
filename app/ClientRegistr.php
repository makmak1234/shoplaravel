<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRegistr extends Model
{
    /**
     * Get the goods for the description.
     */
    public function clientBuy()
    {
        return $this->hasMany('App\clientBuy');
    }

    
}
