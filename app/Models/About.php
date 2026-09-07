<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'mission',
        'vision',
        'image',
    ];
}
