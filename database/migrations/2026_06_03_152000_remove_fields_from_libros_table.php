<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn(['codigo_barras', 'cantidad_total', 'cantidad_disponible']);
        });
    }

    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->string('codigo_barras', 100)->nullable()->unique()->after('isbn');
            $table->integer('cantidad_total')->default(1)->after('signatura');
            $table->integer('cantidad_disponible')->default(1)->after('cantidad_total');
        });
    }
};
