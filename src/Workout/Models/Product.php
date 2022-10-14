<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'product_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'product_id');
    }


}