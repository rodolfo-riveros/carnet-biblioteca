<?php

namespace App\Livewire;

use App\Models\Estudiante;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\PrestamoLibro;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalEstudiantes = 0;

    public int $totalLibros = 0;

    public int $prestamosActivos = 0;

    public int $prestamosVencidos = 0;

    public int $prestamosHoy = 0;

    public int $totalPrestamos = 0;

    public array $librosMasPrestados = [];

    public function mount(): void
    {
        $this->totalEstudiantes = Estudiante::count();
        $this->totalLibros = Libro::count();
        $this->prestamosActivos = Prestamo::where('estado', 'prestado')->count();
        $this->prestamosVencidos = Prestamo::where('estado', 'prestado')
            ->whereDate('fecha_devolucion_prevista', '<', now()->startOfDay())
            ->count();
        $this->prestamosHoy = Prestamo::whereDate('creado_en', today())->count();
        $this->totalPrestamos = Prestamo::count();

        $this->librosMasPrestados = PrestamoLibro::select('libro_id', DB::raw('count(*) as total'))
            ->whereNotNull('libro_id')
            ->groupBy('libro_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('libro')
            ->get()
            ->map(fn ($pl) => [
                'titulo' => $pl->libro?->titulo ?? '—',
                'total' => $pl->total,
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.app');
    }
}
