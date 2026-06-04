<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'carnet_id',
        'fecha_prestamo',
        'fecha_devolucion_prevista',
        'fecha_devolucion_real',
        'estado',
        'metodo_registro',
        'atendido_por',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_prestamo' => 'datetime',
            'fecha_devolucion_prevista' => 'date',
            'fecha_devolucion_real' => 'datetime',
        ];
    }

    protected $attributes = [
        'estado' => 'prestado',
        'metodo_registro' => 'codigo_barras',
    ];

    public function carnet(): BelongsTo
    {
        return $this->belongsTo(Carnet::class);
    }

    public function atendidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'atendido_por');
    }

    public function libros(): HasMany
    {
        return $this->hasMany(PrestamoLibro::class);
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(AlertaDevolucion::class);
    }

    public function getDiasVencidoAttribute(): int
    {
        if (! $this->fecha_devolucion_prevista) {
            return 0;
        }

        return max(0, now()->startOfDay()->diffInDays($this->fecha_devolucion_prevista, false));
    }

    public function getEstaVencidoAttribute(): bool
    {
        return $this->estado === 'prestado' && $this->fecha_devolucion_prevista < now()->startOfDay();
    }
}
