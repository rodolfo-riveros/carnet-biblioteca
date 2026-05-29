<?php

namespace App\Livewire\Admin\Institucion;

use App\Models\Institucion;
use Livewire\Component;
use Livewire\WithPagination;

class InstitucionTable extends Component
{
    use WithPagination;

    // ── Filtros ───────────────────────────────────────────────────────────
    public string $search      = '';
    public string $filtroActivo = '';   // '' | '1' | '0'
    public int    $perPage     = 10;
    public bool   $showDeleted = false;

    // ── Confirmación de eliminación ───────────────────────────────────────
    public ?int $institucionIdParaEliminar = null;

    // ── Reset paginación al filtrar ───────────────────────────────────────
    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFiltroActivo(): void { $this->resetPage(); }
    public function updatingPerPage(): void     { $this->resetPage(); }
    public function updatingShowDeleted(): void { $this->resetPage(); }

    // ── Confirmar eliminación ─────────────────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $this->institucionIdParaEliminar = $id;
    }

    // ── Soft delete ───────────────────────────────────────────────────────
    public function deleteInstitucion(): void
    {
        if (! $this->institucionIdParaEliminar) return;

        $institucion = Institucion::find($this->institucionIdParaEliminar);

        if ($institucion) {
            $institucion->delete();
            session()->flash('message', 'Institución eliminada correctamente.');
        }

        $this->institucionIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-institucion');
    }

    // ── Restaurar ─────────────────────────────────────────────────────────
    public function restoreInstitucion(int $id): void
    {
        Institucion::withTrashed()->findOrFail($id)->restore();
        session()->flash('message', 'Institución restaurada correctamente.');
    }

    // ── Eliminar permanentemente ──────────────────────────────────────────
    public function confirmForceDelete(int $id): void
    {
        $this->institucionIdParaEliminar = $id;
    }

    public function forceDeleteInstitucion(): void
    {
        if (! $this->institucionIdParaEliminar) return;

        Institucion::withTrashed()->findOrFail($this->institucionIdParaEliminar)->forceDelete();
        session()->flash('message', 'Institución eliminada permanentemente.');

        $this->institucionIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-force-delete-institucion');
    }

    // ── Toggle activo directo desde la tabla ──────────────────────────────
    public function toggleActivo(int $id): void
    {
        $institucion = Institucion::findOrFail($id);
        $institucion->update(['activo' => ! $institucion->activo]);
        session()->flash('message', 'Estado actualizado correctamente.');
    }

    // ── Query ─────────────────────────────────────────────────────────────
    protected function getInstituciones()
    {
        $query = Institucion::query();

        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombre', 'like', "%{$this->search}%")
                  ->orWhere('descripcion', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', (bool) $this->filtroActivo);
        }

        return $query->latest()->paginate($this->perPage);
    }

    // ── Render ────────────────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.admin.institucion.institucion-table', [
            'instituciones' => $this->getInstituciones(),
        ]);
    }
}
