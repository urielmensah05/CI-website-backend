<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'icon',
        
    ];
    public function equipe()
{
    return $this->belongsTo(Equipe::class);
}
public function formations()
{
    return $this->hasMany(Formation::class);
}
public function annonces()
{
    return $this->hasMany(Annonce::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}