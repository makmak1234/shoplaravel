<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = ['title', 'created_at', 'updated_at', 'descriptions_id'];

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
        return $this->belongsToMany('App\Size', 'goods_sizes', 'goods_id', 'sizes_id')->withPivot('id');;
    }
}
