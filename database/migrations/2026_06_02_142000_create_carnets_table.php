<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carnets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->string('numero_carnet', 30)->unique();
            $table->string('codigo_barras', 100)->unique();
            $table->string('qr_data', 255)->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->string('estado', 20)->default('activo');
            $table->boolean('impreso')->default(false);
            $table->timestamp('fecha_impresion')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users');
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carnets');
    }
};
