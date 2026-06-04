<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestamoLibro extends Model
{
    use HasFactory;

    protected $table = 'prestamo_libros';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'prestamo_id',
        'libro_id',
        'ejemplar_id',
        'titulo_manual',
        'estado',
        'notas',
    ];

    protected $attributes = [
        'estado' => 'prestado',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }

    public function ejemplar(): BelongsTo
    {
        return $this->belongsTo(Ejemplar::class);
    }
}
