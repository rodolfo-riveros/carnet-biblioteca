<?php

namespace App\Livewire\Admin\Prestamo;

use App\Models\Prestamo;
use Livewire\Component;

class NotificacionesPrestamo extends Component
{
    public int $vencidosCount = 0;

    public array $vencidos = [];

    public function mount(): void
    {
        $this->cargarVencidos();
    }

    public function cargarVencidos(): void
    {
        $prestamos = Prestamo::with([
            'carnet.estudiante',
            'libros.libro',
            'libros.ejemplar',
        ])
            ->where('estado', 'prestado')
            ->whereDate('fecha_devolucion_prevista', '<', now()->startOfDay())
            ->latest('fecha_devolucion_prevista')
            ->get();

        $this->vencidosCount = $prestamos->count();
        $this->vencidos = $prestamos->map(function ($p) {
            return [
                'id' => $p->id,
                'estudiante' => $p->carnet->estudiante->nombres.' '.$p->carnet->estudiante->apellido_paterno,
                'dni' => $p->carnet->estudiante->dni,
                'celular' => $p->carnet->estudiante->celular,
                'libros' => $p->libros->pluck('libro.titulo')->implode(', '),
                'fecha_prevista' => $p->fecha_devolucion_prevista->format('d/m/Y'),
                'dias_vencido' => $p->dias_vencido,
                'prestamo_id' => $p->id,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.admin.prestamo.notificaciones-prestamo');
    }
}
