<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
	protected $fillable = ['ru', 'en'];
    public $timestamps = false;
	
    /**
     * Get the goods for the description.
     */
    public function goods()
    {
        return $this->hasMany('App\Goods');
    }

    /**
     * The Size that belong to the Subca6tegories.
     */
    public function category()
    {
        return $this->belongsToMany('App\Category');
    }
}
