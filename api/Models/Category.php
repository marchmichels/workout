<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function searchCategory($product_id)
    {

        $query = self::where('product_id', "like", "$product_id");
        $results = $query->get();
        return $results;
    }


}