<?php

namespace App\Livewire\Admin\Estudiante;

use App\Models\Estudiante;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class EstudianteTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroEstado = '';

    public int $perPage = 10;

    public ?int $estudianteIdParaEliminar = null;

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

    public function confirmDelete(int $id): void
    {
        $this->estudianteIdParaEliminar = $id;
    }

    public function deleteEstudiante(): void
    {
        if (! $this->estudianteIdParaEliminar) {
            return;
        }

        $estudiante = Estudiante::find($this->estudianteIdParaEliminar);

        if ($estudiante) {
            $estudiante->delete();
            Flux::toast(text: 'Estudiante eliminado correctamente.', variant: 'success');
        }

        $this->estudianteIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-estudiante');
    }

    protected function getEstudiantes()
    {
        $query = Estudiante::with('institucion', 'programaEstudio');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombres', 'like', "%{$this->search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$this->search}%")
                    ->orWhere('apellido_materno', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%")
                    ->orWhere('celular', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroEstado !== '') {
            $query->where('estado', $this->filtroEstado);
        }

        return $query->latest('creado_en')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.estudiante.estudiante-table', [
            'estudiantes' => $this->getEstudiantes(),
        ]);
    }
}
