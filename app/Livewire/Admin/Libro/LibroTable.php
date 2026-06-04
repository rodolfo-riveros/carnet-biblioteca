<?php

namespace App\Livewire\Admin\Libro;

use App\Models\Categoria;
use App\Models\Libro;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class LibroTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $filtroCategoriaId = null;

    public string $filtroEstado = '';

    public int $perPage = 10;

    public ?int $libroIdParaEliminar = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroCategoriaId(): void
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
        $this->libroIdParaEliminar = $id;
    }

    public function deleteLibro(): void
    {
        if (! $this->libroIdParaEliminar) {
            return;
        }

        $libro = Libro::find($this->libroIdParaEliminar);
        if ($libro) {
            $libro->delete();
            Flux::toast(text: 'Libro eliminado correctamente.', variant: 'success');
        }

        $this->libroIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-libro');
    }

    protected function getLibros()
    {
        $query = Libro::with('categoria', 'ejemplares');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('titulo', 'like', "%{$this->search}%")
                    ->orWhere('autor', 'like', "%{$this->search}%")
                    ->orWhere('isbn', 'like', "%{$this->search}%")
                    ->orWhere('codigo_interno', 'like', "%{$this->search}%")
                    ->orWhere('editorial', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroCategoriaId) {
            $query->where('categoria_id', $this->filtroCategoriaId);
        }

        if ($this->filtroEstado !== '') {
            $query->where('estado', $this->filtroEstado);
        }

        return $query->latest('creado_en')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-table', [
            'libros' => $this->getLibros(),
            'categorias' => Categoria::where('activo', true)->get(),
        ]);
    }
}
