<?php

namespace App\Livewire\Admin\ProgramaEstudio;

use App\Models\Institucion;
use App\Models\ProgramaEstudio;
use Flux\Flux;
use Livewire\Component;

class ProgramaEstudioForm extends Component
{
    public ?int $programaEstudioId = null;

    public bool $isEditMode = false;

    public string $nombre = '';

    public ?int $institucion_id = null;

    public bool $activo = true;

    protected function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:150',
                'unique:programa_estudios,nombre'.($this->programaEstudioId ? ",{$this->programaEstudioId}" : ''),
            ],
            'institucion_id' => ['required', 'exists:institucions,id'],
            'activo' => ['boolean'],
        ];
    }

    protected array $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
        'nombre.unique' => 'Ya existe un programa de estudio con ese nombre.',
        'institucion_id.required' => 'Debe seleccionar una institución.',
        'institucion_id.exists' => 'La institución seleccionada no existe.',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $programaEstudio = ProgramaEstudio::findOrFail($id);
            $this->programaEstudioId = $id;
            $this->isEditMode = true;
            $this->nombre = $programaEstudio->nombre;
            $this->institucion_id = $programaEstudio->institucion_id;
            $this->activo = (bool) $programaEstudio->activo;
        }
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->isEditMode) {
            ProgramaEstudio::findOrFail($this->programaEstudioId)->update($data);
            Flux::toast(text: 'Programa de estudio actualizado correctamente.', variant: 'success');
        } else {
            ProgramaEstudio::create($data);
            Flux::toast(text: 'Programa de estudio registrado correctamente.', variant: 'success');
            $this->reset(['nombre', 'institucion_id', 'activo']);
            $this->activo = true;
        }

        $this->dispatch('programa-estudio-guardado');
        $this->redirectRoute('programa-estudios.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.programa-estudio.programa-estudio-form', [
            'instituciones' => Institucion::where('activo', true)->get(),
        ]);
    }
}
