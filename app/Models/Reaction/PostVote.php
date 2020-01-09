<?php

namespace App\Models\Reaction;

use Illuminate\Database\Eloquent\Model;

class PostVote extends Model
{
    protected $table = 'post_votes';

    protected $fillable = [
        'user_id', 'post_id',
        'vote'  
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function Post()
    {
        return $this->belongsTo('App\Models\HelpCenter\Post');
    }

}   
