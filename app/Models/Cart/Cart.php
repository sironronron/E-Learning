<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'user_id', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
