<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'equipes';

    protected $fillable = [
        'nom',
        'poste',
        'photo',
        'bio',
        
    ];
    public function services()
{
    return $this->hasMany(Service::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}