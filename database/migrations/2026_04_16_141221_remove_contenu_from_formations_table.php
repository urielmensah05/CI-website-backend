<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('formations', 'contenu')) {
            Schema::table('formations', function (Blueprint $table) {
                $table->dropColumn('contenu');
            });
        }
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->text('contenu')->nullable();
        });
    }
};