<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partenaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'logo',
        'lien',
        'user_id'
    ];

    // 🔗 Relation : un partenaire appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}