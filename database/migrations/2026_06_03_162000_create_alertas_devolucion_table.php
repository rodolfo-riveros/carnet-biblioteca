<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas_devolucion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->cascadeOnDelete();
            $table->foreignId('carnet_id')->constrained('carnets');
            $table->string('tipo_alerta', 30);
            $table->text('mensaje');
            $table->string('celular_destino', 20);
            $table->boolean('enviada')->default(false);
            $table->timestamp('fecha_envio')->nullable();
            $table->string('canal', 20)->default('sistema');
            $table->integer('dias_vencido')->default(0);
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas_devolucion');
    }
};
