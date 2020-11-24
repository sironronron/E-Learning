<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id', 'course_id', 'price'
    ];

    /**
     * 
     * @return array
     */
    public function cart()
    {
        return $this->belongsTo('App\Models\Cart\Cart', 'cart_id');
    }

    /**
     * 
     * @return array
     */
    public function courses()
    {
        return $this->belongsToMany('App\Models\Course\Course', 'course_id');
    }
}
