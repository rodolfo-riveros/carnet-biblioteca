<?php

namespace App\Livewire\Admin\ProgramaEstudio;

use App\Models\ProgramaEstudio;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramaEstudioTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroActivo = '';

    public int $perPage = 10;

    public ?int $programaEstudioIdParaEliminar = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroActivo(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->programaEstudioIdParaEliminar = $id;
    }

    public function deleteProgramaEstudio(): void
    {
        if (! $this->programaEstudioIdParaEliminar) {
            return;
        }

        $programaEstudio = ProgramaEstudio::find($this->programaEstudioIdParaEliminar);

        if ($programaEstudio) {
            $programaEstudio->delete();
            Flux::toast(text: 'Programa de estudio eliminado correctamente.', variant: 'success');
        }

        $this->programaEstudioIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-programa-estudio');
    }

    public function toggleActivo(int $id): void
    {
        $programaEstudio = ProgramaEstudio::findOrFail($id);
        $programaEstudio->update(['activo' => ! $programaEstudio->activo]);
        Flux::toast(text: 'Estado actualizado correctamente.', variant: 'success');
    }

    protected function getProgramasEstudio()
    {
        $query = ProgramaEstudio::with('institucion');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', (bool) $this->filtroActivo);
        }

        return $query->latest()->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.programa-estudio.programa-estudio-table', [
            'programasEstudio' => $this->getProgramasEstudio(),
        ]);
    }
}
