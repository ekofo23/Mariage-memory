<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('photos', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable();
        $table->string('code')->nullable()->index(); // Pour la recherche par nom/code/invité
        $table->string('original_path');             // Fichier HD original pour le téléchargement
        $table->string('thumbnail_path');            // Miniature optimisée pour l'affichage rapide
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->integer('download_count')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
};
