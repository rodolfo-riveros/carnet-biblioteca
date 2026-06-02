<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 20)->unique();
            $table->string('nombres', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('celular', 20);
            $table->string('celular_alternativo', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('foto_ruta', 255)->nullable();
            $table->foreignId('institucion_id')->constrained('institucions');
            $table->foreignId('programa_estudio_id')->nullable()->constrained('programa_estudios');
            $table->string('codigo_alumno', 50)->nullable();
            $table->year('anio_ingreso')->nullable();
            $table->year('anio_egreso')->nullable();
            $table->string('estado', 20)->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
