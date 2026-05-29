<?php

namespace App\Livewire\Admin\Institucion;

use App\Models\Institucion;
use Livewire\Component;

class InstitucionForm extends Component
{
    // ── Modo ──────────────────────────────────────────────────────────────
    public ?int $institucionId = null;
    public bool $isEditMode    = false;

    // ── Campos del formulario ─────────────────────────────────────────────
    public string $nombre      = '';
    public string $descripcion = '';
    public bool   $activo      = true;

    // ── Reglas de validación ──────────────────────────────────────────────
    protected function rules(): array
    {
        return [
            'nombre'      => [
                'required',
                'string',
                'min:3',
                'max:150',
                'unique:institucions,nombre' . ($this->institucionId ? ",{$this->institucionId}" : ''),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo'      => ['boolean'],
        ];
    }

    protected array $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min'      => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max'      => 'El nombre no puede superar los 150 caracteres.',
        'nombre.unique'   => 'Ya existe una institución con ese nombre.',
        'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
    ];

    // ── Lifecycle ─────────────────────────────────────────────────────────
    public function mount(?int $id = null): void
    {
        if ($id) {
            $institucion       = Institucion::findOrFail($id);
            $this->institucionId = $id;
            $this->isEditMode    = true;
            $this->nombre        = $institucion->nombre;
            $this->descripcion   = $institucion->descripcion ?? '';
            $this->activo        = (bool) $institucion->activo;
        }
    }

    // ── Validación en tiempo real ─────────────────────────────────────────
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    // ── Guardar ───────────────────────────────────────────────────────────
    public function save(): void
    {
        $data = $this->validate();

        if ($this->isEditMode) {
            Institucion::findOrFail($this->institucionId)->update($data);
            session()->flash('message', 'Institución actualizada correctamente.');
        } else {
            Institucion::create($data);
            session()->flash('message', 'Institución registrada correctamente.');
            $this->reset(['nombre', 'descripcion', 'activo']);
            $this->activo = true;
        }

        $this->dispatch('institucion-guardada');
        $this->redirectRoute('instituciones.index', navigate: true);
    }

    // ── Render ────────────────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.admin.institucion.institucion-form');
    }
}
