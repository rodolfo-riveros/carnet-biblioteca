<?php

namespace App\Livewire\Admin\Categoria;

use App\Models\Categoria;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriaTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroActivo = '';

    public int $perPage = 10;

    public ?int $categoriaIdParaEliminar = null;

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
        $this->categoriaIdParaEliminar = $id;
    }

    public function deleteCategoria(): void
    {
        if (! $this->categoriaIdParaEliminar) {
            return;
        }

        $categoria = Categoria::find($this->categoriaIdParaEliminar);

        if ($categoria) {
            $categoria->delete();
            Flux::toast(text: 'Categoría eliminada correctamente.', variant: 'success');
        }

        $this->categoriaIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-categoria');
    }

    public function toggleActivo(int $id): void
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update(['activo' => ! $categoria->activo]);
        Flux::toast(text: 'Estado actualizado correctamente.', variant: 'success');
    }

    protected function getCategorias()
    {
        $query = Categoria::query();

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

    public function render()
    {
        return view('livewire.admin.categoria.categoria-table', [
            'categorias' => $this->getCategorias(),
        ]);
    }
}
