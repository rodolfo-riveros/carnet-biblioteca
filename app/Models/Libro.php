<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'autor',
        'co_autores',
        'isbn',
        'codigo_interno',
        'editorial',
        'lugar_publicacion',
        'anio_publicacion',
        'edicion',
        'paginas',
        'idioma',
        'descripcion',
        'palabras_clave',
        'categoria_id',
        'ubicacion_estante',
        'signatura',
        'portada_ruta',
    ];

    protected function casts(): array
    {
        return [
            'anio_publicacion' => 'integer',
            'paginas' => 'integer',
        ];
    }

    protected $attributes = [
        'idioma' => 'Español',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ejemplares(): HasMany
    {
        return $this->hasMany(Ejemplar::class);
    }

    public function ejemplaresDisponibles(): HasMany
    {
        return $this->hasMany(Ejemplar::class)->where('estado', 'disponible');
    }
}
