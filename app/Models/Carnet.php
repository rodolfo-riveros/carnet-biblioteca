<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carnet extends Model
{
    use HasFactory;

    protected $table = 'carnets';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'estudiante_id',
        'numero_carnet',
        'codigo_barras',
        'qr_data',
        'fecha_emision',
        'fecha_vencimiento',
        'estado',
        'impreso',
        'fecha_impresion',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_emision' => 'date',
            'fecha_vencimiento' => 'date',
            'impreso' => 'boolean',
            'fecha_impresion' => 'datetime',
        ];
    }

    protected $attributes = [
        'estado' => 'activo',
        'impreso' => false,
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
