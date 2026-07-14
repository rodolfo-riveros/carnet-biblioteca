<?php

namespace App\Livewire\Admin\Libro;

use App\Exports\PlantillaLibrosExport;
use App\Imports\LibrosImport;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class LibroImportar extends Component
{
    use WithFileUploads;

    public $archivo = null;

    public array $preview = [];

    public array $errores = [];

    public int $importados = 0;

    public int $fallidos = 0;

    public bool $importando = false;

    protected function rules(): array
    {
        return [
            'archivo' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ];
    }

    protected array $messages = [
        'archivo.required' => 'Debe seleccionar un archivo.',
        'archivo.file' => 'Debe ser un archivo válido.',
        'archivo.mimes' => 'El archivo debe ser .xlsx, .xls o .csv.',
        'archivo.max' => 'El archivo no debe superar los 2MB.',
    ];

    public function descargarPlantilla()
    {
        return Excel::download(new PlantillaLibrosExport, 'plantilla_libros.xlsx');
    }

    public function updatedArchivo(): void
    {
        $this->validateOnly('archivo');
        $this->preview = [];
        $this->errores = [];
        $this->importados = 0;
        $this->fallidos = 0;

        try {
            $rows = Excel::toCollection(new LibrosImport, $this->archivo->getRealPath());
            $allRows = $rows->first()?->toArray() ?? [];
            $this->preview = array_values(array_filter($allRows, function ($row) {
                return collect($row)->filter(fn ($v) => filled(trim((string) $v)))->isNotEmpty();
            }));
        } catch (\Exception $e) {
            Flux::toast(text: 'Error al leer el archivo: '.$e->getMessage(), variant: 'danger');
        }
    }

    public function importar(): void
    {
        $this->validate();

        if (! $this->archivo) {
            return;
        }

        $this->importando = true;
        $this->importados = 0;
        $this->fallidos = 0;
        $this->errores = [];

        try {
            $import = new LibrosImport;
            Excel::import($import, $this->archivo->getRealPath());

            $this->importados = $import->importados;
            $this->fallidos = $import->fallidos;
            $this->errores = $import->errores;
        } catch (\Exception $e) {
            Flux::toast(text: 'Error durante la importación: '.$e->getMessage(), variant: 'danger');
        }

        $this->importando = false;
        $this->dispatch('importacion-completada');

        Flux::toast(
            text: "Importación completada: {$this->importados} creados, {$this->fallidos} fallidos.",
            variant: $this->fallidos > 0 ? 'warning' : 'success'
        );
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-importar');
    }
}
