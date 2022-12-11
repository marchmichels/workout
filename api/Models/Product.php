<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;
use Workout\Models\Category;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public static function searchProducts($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('product_id', "like", "%$terms%");
        } else {
            $query = self::where('product_name', 'like', "%$terms%")
                ->orWhere('description', 'like', "%$terms%");
        }
        $results = $query->get();
        return $results;
    }

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