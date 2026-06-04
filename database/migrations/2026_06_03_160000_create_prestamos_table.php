<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carnet_id')->constrained('carnets');
            $table->timestamp('fecha_prestamo')->useCurrent();
            $table->date('fecha_devolucion_prevista');
            $table->timestamp('fecha_devolucion_real')->nullable();
            $table->string('estado', 20)->default('prestado');
            $table->string('metodo_registro', 20)->default('codigo_barras');
            $table->foreignId('atendido_por')->nullable()->constrained('users');
            $table->text('observaciones')->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
