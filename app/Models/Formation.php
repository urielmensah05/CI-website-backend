<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations';

    protected $fillable = [
        'titre',
        'description',
        'image',
        
    ];
    public function service()
{
    return $this->belongsTo(Service::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}