<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ejemplar extends Model
{
    use HasFactory;

    protected $table = 'ejemplares';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'libro_id',
        'numero_copia',
        'codigo_barras',
        'estado',
        'notas',
    ];

    protected $attributes = [
        'estado' => 'disponible',
    ];

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }
}
