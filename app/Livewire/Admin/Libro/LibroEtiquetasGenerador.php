<?php

namespace App\Livewire\Admin\Libro;

use Livewire\Component;

class LibroEtiquetasGenerador extends Component
{
    public int $startId = 1;

    public int $endId = 10;

    public ?string $pdfUrl = null;

    public ?string $message = null;

    public function generarEtiquetas(): void
    {
        if ($this->startId < 1 || $this->endId < $this->startId) {
            $this->message = 'Los IDs ingresados no son válidos.';
            $this->pdfUrl = null;

            return;
        }

        $this->message = null;
        $this->pdfUrl = route('libros.barcode.pdf', [
            'startId' => $this->startId,
            'endId' => $this->endId,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-etiquetas-generador');
    }
}
