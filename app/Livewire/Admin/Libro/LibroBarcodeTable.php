<?php

namespace App\Livewire\Admin\Libro;

use App\Models\Ejemplar;
use App\Models\Libro;
use Livewire\Component;
use Livewire\WithPagination;

class LibroBarcodeTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $libroId = null;

    public int $perPage = 15;

    public ?int $ejemplarIdParaEliminar = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function downloadBarcode(int $id)
    {
        $this->js('window.location.href = "'.route('libros.barcode.ejemplar', $id).'"');
    }

    public function confirmDelete(int $id): void
    {
        $this->ejemplarIdParaEliminar = $id;
    }

    public function deleteEjemplar(): void
    {
        if (! $this->ejemplarIdParaEliminar) {
            return;
        }

        $ejemplar = Ejemplar::find($this->ejemplarIdParaEliminar);
        if ($ejemplar) {
            $ejemplar->delete();
        }

        $this->ejemplarIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-eliminar-ejemplar');
    }

    protected function getEjemplares()
    {
        $query = Ejemplar::with('libro:id,titulo');

        if ($this->search !== '') {
            $query->whereHas('libro', function ($q) {
                $q->where('titulo', 'like', "%{$this->search}%")
                    ->orWhere('codigo_interno', 'like', "%{$this->search}%")
                    ->orWhere('autor', 'like', "%{$this->search}%");
            })->orWhere('codigo_barras', 'like', "%{$this->search}%")
                ->orWhere('numero_copia', 'like', "%{$this->search}%")
                ->orWhere('estado', 'like', "%{$this->search}%");
        }

        if ($this->libroId) {
            $query->where('libro_id', $this->libroId);
        }

        return $query->latest('created_at')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-barcode-table', [
            'ejemplares' => $this->getEjemplares(),
            'libros' => Libro::where('activo', true)->orderBy('titulo')->get(['id', 'titulo', 'codigo_interno']),
        ]);
    }
}
