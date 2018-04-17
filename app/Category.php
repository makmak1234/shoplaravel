<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['en', 'ru'];
	public $timestamps = false;

    /**
     * Get the goods for the description.
     */
    public function goods()
    {
        return $this->hasMany('App\Goods');
    }

    /**
     * The Size that belong to the Subcategories.
     */
    public function subcategory()
    {
        return $this->belongsToMany('App\Subcategory', 'category_subcats', 'category_id', 'subcategory_id')->withPivot('id');
    }
}
