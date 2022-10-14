<?php
//Comment.php

namespace Workout\Models;

use \Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';

    public function product()
    {
        //one to one relation
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        //one to one relation
        return $this->belongsTo(User::class, 'user_id');
    }


}