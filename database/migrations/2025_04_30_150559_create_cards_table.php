<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('name'); // nombre del futbolista (clave para el match)
            $table->string('image_url'); // URL o ruta a la imagen
            $table->timestamps(); // created_at y updated_at automáticos
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
