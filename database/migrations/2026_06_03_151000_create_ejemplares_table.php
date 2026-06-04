<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejemplares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('libro_id')->constrained('libros')->cascadeOnDelete();
            $table->string('numero_copia', 20);
            $table->string('codigo_barras', 100)->nullable()->unique();
            $table->string('estado', 20)->default('disponible');
            $table->string('notas', 255)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejemplares');
    }
};
