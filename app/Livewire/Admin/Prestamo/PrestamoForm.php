<?php

namespace App\Livewire\Admin\Prestamo;

use App\Models\Carnet;
use App\Models\Ejemplar;
use App\Models\Prestamo;
use App\Models\PrestamoLibro;
use Flux\Flux;
use Livewire\Component;

class PrestamoForm extends Component
{
    public ?int $prestamoId = null;

    public bool $isEditMode = false;

    // ── Escaneo ──────────────────────────────────────────────────────────
    public string $codigoCarnet = '';

    public string $codigoEjemplar = '';

    // ── Datos del estudiante (auto) ──────────────────────────────────────
    public ?string $estudianteNombre = null;

    public ?string $estudianteDni = null;

    public ?string $estudianteCelular = null;

    public ?int $carnetId = null;

    // ── Libros agregados ─────────────────────────────────────────────────
    public array $libros = [];

    // ── Fechas ───────────────────────────────────────────────────────────
    public $diasPrestamo = 5;

    public ?string $fechaDevolucionPrevista = null;

    public ?string $observaciones = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $prestamo = Prestamo::with('carnet.estudiante', 'libros.libro', 'libros.ejemplar')->findOrFail($id);
            $this->prestamoId = $id;
            $this->isEditMode = true;
            $this->carnetId = $prestamo->carnet_id;
            $this->estudianteNombre = $prestamo->carnet->estudiante->nombres.' '.$prestamo->carnet->estudiante->apellido_paterno;
            $this->estudianteDni = $prestamo->carnet->estudiante->dni;
            $this->codigoCarnet = $prestamo->carnet->numero_carnet;
            $this->fechaDevolucionPrevista = $prestamo->fecha_devolucion_prevista->format('Y-m-d');
            $this->observaciones = $prestamo->observaciones;

            foreach ($prestamo->libros as $pl) {
                $this->libros[] = [
                    'id' => $pl->id,
                    'titulo' => $pl->libro?->titulo ?? $pl->titulo_manual,
                    'codigo' => $pl->ejemplar?->codigo_barras ?? '—',
                    'ejemplar_id' => $pl->ejemplar_id,
                    'estado' => $pl->estado,
                ];
            }
        }
    }

    public function updatedCodigoCarnet(): void
    {
        if (empty($this->codigoCarnet)) {
            return;
        }

        $carnet = Carnet::where('numero_carnet', $this->codigoCarnet)
            ->orWhere('codigo_barras', $this->codigoCarnet)
            ->with('estudiante')
            ->first();

        if (! $carnet) {
            Flux::toast(text: 'Carnet no encontrado. Verifica el código.', variant: 'warning');

            return;
        }

        $this->carnetId = $carnet->id;
        $this->estudianteNombre = $carnet->estudiante->nombres.' '.$carnet->estudiante->apellido_paterno.' '.$carnet->estudiante->apellido_materno;
        $this->estudianteDni = $carnet->estudiante->dni;
        $this->estudianteCelular = $carnet->estudiante->celular;
    }

    public function updatedCodigoEjemplar(): void
    {
        if (empty($this->codigoEjemplar)) {
            return;
        }

        $ejemplar = Ejemplar::where('codigo_barras', $this->codigoEjemplar)
            ->where('estado', 'disponible')
            ->with('libro')
            ->first();

        if (! $ejemplar) {
            Flux::toast(text: 'Ejemplar no encontrado o no disponible.', variant: 'warning');
            $this->codigoEjemplar = '';

            return;
        }

        $yaAgregado = collect($this->libros)->contains('ejemplar_id', $ejemplar->id);
        if ($yaAgregado) {
            Flux::toast(text: 'Este ejemplar ya fue agregado al préstamo.', variant: 'warning');
            $this->codigoEjemplar = '';

            return;
        }

        $this->libros[] = [
            'id' => null,
            'titulo' => $ejemplar->libro->titulo,
            'codigo' => $ejemplar->codigo_barras,
            'ejemplar_id' => $ejemplar->id,
            'estado' => 'prestado',
        ];

        $this->codigoEjemplar = '';

        $ejemplar->update(['estado' => 'prestado']);

        Flux::toast(text: "Libro «{$ejemplar->libro->titulo}» agregado.", variant: 'success');
    }

    public function updatedDiasPrestamo($value): void
    {
        $this->fechaDevolucionPrevista = now()->addDays((int) $value)->format('Y-m-d');
    }

    public function quitarLibro(int $index): void
    {
        if (isset($this->libros[$index])) {
            $ejemplarId = $this->libros[$index]['ejemplar_id'];
            if ($ejemplarId) {
                Ejemplar::find($ejemplarId)?->update(['estado' => 'disponible']);
            }
            unset($this->libros[$index]);
            $this->libros = array_values($this->libros);
        }
    }

    public function save(): void
    {
        if (! $this->carnetId) {
            Flux::toast(text: 'Debes escanear un carnet de estudiante.', variant: 'danger');

            return;
        }

        if (empty($this->libros)) {
            Flux::toast(text: 'Debes agregar al menos un libro.', variant: 'danger');

            return;
        }

        if (! $this->fechaDevolucionPrevista) {
            $this->fechaDevolucionPrevista = now()->addDays($this->diasPrestamo)->format('Y-m-d');
        }

        $data = [
            'carnet_id' => $this->carnetId,
            'fecha_devolucion_prevista' => $this->fechaDevolucionPrevista,
            'estado' => 'prestado',
            'metodo_registro' => 'codigo_barras',
            'atendido_por' => auth()->id(),
            'observaciones' => $this->observaciones,
        ];

        if ($this->isEditMode) {
            $prestamo = Prestamo::findOrFail($this->prestamoId);
            $prestamo->update($data);
            Flux::toast(text: 'Préstamo actualizado correctamente.', variant: 'success');
        } else {
            $prestamo = Prestamo::create($data);

            foreach ($this->libros as $libro) {
                PrestamoLibro::create([
                    'prestamo_id' => $prestamo->id,
                    'libro_id' => null,
                    'ejemplar_id' => $libro['ejemplar_id'],
                    'estado' => 'prestado',
                ]);
            }

            Flux::toast(text: 'Préstamo registrado correctamente.', variant: 'success');

            $this->reset([
                'codigoCarnet', 'codigoEjemplar', 'estudianteNombre',
                'estudianteDni', 'estudianteCelular', 'carnetId',
                'libros', 'observaciones',
            ]);
            $this->diasPrestamo = 5;
            $this->fechaDevolucionPrevista = null;
        }

        $this->dispatch('prestamo-guardado');
        $this->redirectRoute('prestamos.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.prestamo.prestamo-form');
    }
}
