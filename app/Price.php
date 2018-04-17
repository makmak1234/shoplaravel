<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['rub', 'uah', 'usd', 'eur'];
    public $timestamps = false;
    
    /**
     * The Goods that belong to the Size.
     */
    public function goods()
    {
        return $this->hasMany('App\Goods');
    }
}
