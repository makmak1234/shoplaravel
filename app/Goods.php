<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = ['title', 'created_at', 'updated_at', 'descriptions_id', 'categories_id', 'subcategories_id'];

    /**
     * Get the goods that owns the description.
     */
    public function descriptions()
    {
        return $this->belongsTo('App\Description');
    }

    /**
     * The Size that belong to the Goods.
     */
    public function size()
    {
        return $this->belongsToMany('App\Size', 'goods_sizes', 'goods_id', 'sizes_id')->withPivot('id');
    }

    /**
     * Get the goods that owns the category.
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'categories_id');
    }

    /**
     * Get the goods that owns the subcategory.
     */
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'subcategories_id');
    }

    /**
     * Get the goods for the description.
     */
    public function clientBuy()
    {
        return $this->hasMany('App\clientBuy');
    }
}
