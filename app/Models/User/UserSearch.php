<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model
{
    protected $table = 'user_searches';

    protected $fillable = ['user_id', 'search_term'];

    /**
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
