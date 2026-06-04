<?php

namespace App\Livewire\Admin\Prestamo;

use App\Models\Prestamo;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class PrestamoTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroEstado = '';

    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function devolver(int $id): void
    {
        $prestamo = Prestamo::with('libros')->findOrFail($id);

        foreach ($prestamo->libros as $pl) {
            $pl->update(['estado' => 'devuelto']);
            if ($pl->ejemplar) {
                $pl->ejemplar->update(['estado' => 'disponible']);
            }
        }

        $prestamo->update([
            'estado' => 'devuelto',
            'fecha_devolucion_real' => now(),
        ]);

        Flux::toast(text: 'Préstamo devuelto correctamente.', variant: 'success');
    }

    protected function getPrestamos()
    {
        $query = Prestamo::with([
            'carnet.estudiante',
            'libros.libro',
            'libros.ejemplar',
            'atendidoPor',
        ]);

        if ($this->search !== '') {
            $query->whereHas('carnet.estudiante', function ($q) {
                $q->where('nombres', 'like', "%{$this->search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$this->search}%")
                    ->orWhere('apellido_materno', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%");
            })->orWhereHas('libros.libro', function ($q) {
                $q->where('titulo', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroEstado !== '') {
            $query->where('estado', $this->filtroEstado);
        }

        return $query->latest('creado_en')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.prestamo.prestamo-table', [
            'prestamos' => $this->getPrestamos(),
        ]);
    }
}
