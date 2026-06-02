<?php

namespace App\Livewire\Admin\Categoria;

use App\Models\Categoria;
use Flux\Flux;
use Livewire\Component;

class CategoriaForm extends Component
{
    public ?int $categoriaId = null;

    public bool $isEditMode = false;

    public string $nombre = '';

    public string $descripcion = '';

    public bool $activo = true;

    protected function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:categoria,nombre'.($this->categoriaId ? ",{$this->categoriaId}" : ''),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['boolean'],
        ];
    }

    protected array $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
        'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $categoria = Categoria::findOrFail($id);
            $this->categoriaId = $id;
            $this->isEditMode = true;
            $this->nombre = $categoria->nombre;
            $this->descripcion = $categoria->descripcion ?? '';
            $this->activo = (bool) $categoria->activo;
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
            Categoria::findOrFail($this->categoriaId)->update($data);
            Flux::toast(text: 'Categoría actualizada correctamente.', variant: 'success');
        } else {
            Categoria::create($data);
            Flux::toast(text: 'Categoría registrada correctamente.', variant: 'success');
            $this->reset(['nombre', 'descripcion', 'activo']);
            $this->activo = true;
        }

        $this->dispatch('categoria-guardada');
        $this->redirectRoute('categorias.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.categoria.categoria-form');
    }
}
