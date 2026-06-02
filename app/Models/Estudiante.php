<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    const CREATED_AT = 'creado_en';

    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'celular',
        'celular_alternativo',
        'email',
        'foto_ruta',
        'institucion_id',
        'programa_estudio_id',
        'codigo_alumno',
        'anio_ingreso',
        'anio_egreso',
        'estado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'anio_ingreso' => 'integer',
            'anio_egreso' => 'integer',
        ];
    }

    protected $attributes = [
        'estado' => 'activo',
    ];

    public function institucion(): BelongsTo
    {
        return $this->belongsTo(Institucion::class);
    }

    public function programaEstudio(): BelongsTo
    {
        return $this->belongsTo(ProgramaEstudio::class);
    }
}
