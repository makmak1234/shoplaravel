<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
	protected $fillable = ['title'];
	public $timestamps = false;

    /**
     * Get the goods for the description.
     */
    public function goods()
    {
        return $this->hasMany('App\Goods');
    }
}
