<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamo_libros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->cascadeOnDelete();
            $table->foreignId('libro_id')->nullable()->constrained('libros');
            $table->foreignId('ejemplar_id')->nullable()->constrained('ejemplares');
            $table->string('titulo_manual', 300)->nullable();
            $table->string('estado', 20)->default('prestado');
            $table->string('notas', 255)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamo_libros');
    }
};
