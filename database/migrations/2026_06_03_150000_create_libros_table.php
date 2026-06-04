<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 300);
            $table->string('subtitulo', 300)->nullable();
            $table->string('autor', 200);
            $table->string('co_autores', 300)->nullable();
            $table->string('isbn', 20)->nullable();
            $table->string('codigo_barras', 100)->nullable()->unique();
            $table->string('codigo_interno', 50)->unique();
            $table->string('editorial', 150)->nullable();
            $table->string('lugar_publicacion', 100)->nullable();
            $table->year('anio_publicacion')->nullable();
            $table->string('edicion', 50)->nullable();
            $table->integer('paginas')->nullable();
            $table->string('idioma', 50)->default('Español');
            $table->text('descripcion')->nullable();
            $table->string('palabras_clave', 500)->nullable();
            $table->foreignId('categoria_id')->nullable()->constrained('categoria');
            $table->string('ubicacion_estante', 50)->nullable();
            $table->string('signatura', 100)->nullable();
            $table->integer('cantidad_total')->default(1);
            $table->integer('cantidad_disponible')->default(1);
            $table->string('estado', 30)->default('disponible');
            $table->string('portada_ruta', 255)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
