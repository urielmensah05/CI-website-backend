<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_textes', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique();        // clé unique (ex: hero_titre, hero_description)
            $table->text('valeur');                   // le texte à afficher
            $table->string('section')->default('general'); // section du site (hero, services, contact, etc.)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_textes');
    }
};
