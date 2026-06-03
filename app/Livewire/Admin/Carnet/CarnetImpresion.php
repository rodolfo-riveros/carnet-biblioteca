<?php

namespace App\Livewire\Admin\Carnet;

use App\Models\Estudiante;
use Livewire\Component;

class CarnetImpresion extends Component
{
    public string $institucion_id = '';

    public string $programa_estudio_id = '';

    public string $estado = '';

    public string $search = '';

    public function mount(): void
    {
        $this->institucion_id = request()->query('institucion_id', '');
        $this->programa_estudio_id = request()->query('programa_estudio_id', '');
        $this->estado = request()->query('estado', '');
        $this->search = request()->query('search', '');
    }

    public function render()
    {
        $query = Estudiante::with('institucion', 'programaEstudio', 'carnet');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombres', 'like', "%{$this->search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$this->search}%")
                    ->orWhere('apellido_materno', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%");
            });
        }

        if ($this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        if ($this->institucion_id !== '') {
            $query->where('institucion_id', $this->institucion_id);
        }

        if ($this->programa_estudio_id !== '') {
            $query->where('programa_estudio_id', $this->programa_estudio_id);
        }

        $estudiantes = $query->get();

        return view('livewire.admin.carnet.carnet-impresion', [
            'estudiantes' => $estudiantes,
        ])->layout('layouts.print');
    }
}
