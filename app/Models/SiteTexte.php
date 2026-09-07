<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTexte extends Model
{
    protected $table = 'site_textes';

    protected $fillable = [
        'cle',
        'valeur',
        'section',
    ];
}
