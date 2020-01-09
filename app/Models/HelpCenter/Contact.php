<?php

namespace App\Models\HelpCenter;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'customer_service_inquiries';

    protected $dates = [
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'role', 'subject', 'email', 'body', 'agreed_terms', 'name'
    ];
}
