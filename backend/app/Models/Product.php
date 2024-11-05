<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'name', 'sku', 'quantity', 'price', 'cat_id' ];

    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id','id');
    }
}