<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    
    protected $fillable = [
        'Name',
        'Email',
        'Subject',
        'Rating',
        'Message',
        'Status'
    ];
}
