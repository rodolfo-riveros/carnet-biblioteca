<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertaDevolucion extends Model
{
    use HasFactory;

    protected $table = 'alertas_devolucion';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = null;

    protected $fillable = [
        'prestamo_id',
        'carnet_id',
        'tipo_alerta',
        'mensaje',
        'celular_destino',
        'enviada',
        'fecha_envio',
        'canal',
        'dias_vencido',
    ];

    protected function casts(): array
    {
        return [
            'enviada' => 'boolean',
            'fecha_envio' => 'datetime',
            'dias_vencido' => 'integer',
        ];
    }

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function carnet(): BelongsTo
    {
        return $this->belongsTo(Carnet::class);
    }
}
