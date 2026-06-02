<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramaEstudio extends Model
{
    use HasFactory;

    protected $table = 'programa_estudios';

    protected $fillable = [
        'nombre',
        'institucion_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    protected $attributes = [
        'activo' => true,
    ];

    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }
}
