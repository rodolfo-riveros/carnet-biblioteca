<?php

namespace App\Livewire\Admin\Libro;

use App\Models\Ejemplar;
use App\Models\Libro;
use Livewire\Component;

class LibroBarcodeLibrosGenerador extends Component
{
    public array $libros = [];

    public bool $faltaCodigo = false;

    public bool $showPreview = false;

    public function mount(): void
    {
        $this->generarListaLibros();
    }

    public function updatedFaltaCodigo(): void
    {
        $this->generarListaLibros();
    }

    public function generarYDescargar($ejemplarId): void
    {
        $this->js('window.location.href = "'.route('libros.barcode.ejemplar', $ejemplarId).'"');
    }

    protected function generarListaLibros(): void
    {
        $query = Ejemplar::with('libro:id,titulo,codigo_interno')
            ->orderBy('created_at', 'desc');

        if ($this->faltaCodigo) {
            $query->where(function ($q) {
                $q->whereNull('codigo_barras')
                    ->orWhere('codigo_barras', '');
            });
        }

        $ejemplares = $query->get();

        $this->libros = $ejemplares->map(function ($ejemplar) {
            return [
                'id' => $ejemplar->id,
                'ejemplar_id' => $ejemplar->id,
                'titulo' => $ejemplar->libro?->titulo ?? 'Sin título',
                'codigo_interno' => $ejemplar->libro?->codigo_interno ?? '—',
                'codigo_barras' => $ejemplar->codigo_barras,
                'numero_copia' => $ejemplar->numero_copia,
            ];
        })->toArray();
    }

    protected function generarCodigoBarra(int $libroId): string
    {
        $maxId = Libro::max('id') ?? 0;
        $maxEj = Ejemplar::max('id') ?? 0;
        $seq = max($maxId, $maxEj) + 1;

        return 'CB'.date('Ymd').str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    public function generateLabels(): void
    {
        $ids = collect($this->libros)->pluck('ejemplar_id')->filter()->implode(',');

        if (empty($ids)) {
            $this->dispatch('show-toast', ['message' => 'No hay ejemplares para generar etiquetas.']);

            return;
        }

        $this->js('window.location.href = "'.route('libros.barcode.ejemplares-masivo', ['ids' => $ids]).'"');
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-barcode-libros-generador');
    }
}
