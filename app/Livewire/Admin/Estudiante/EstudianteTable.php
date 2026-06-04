<?php

namespace App\Livewire\Admin\Estudiante;

use App\Models\Estudiante;
use App\Models\Institucion;
use App\Models\ProgramaEstudio;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class EstudianteTable extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $filtroInstitucionId = null;

    public ?int $filtroProgramaEstudioId = null;

    public int $perPage = 10;

    public ?int $estudianteIdParaEliminar = null;

    public ?int $estudianteIdCarnet = null;

    public ?string $pdfUrl = null;

    public bool $showMassCarnetModal = false;

    public ?string $massPdfUrl = null;

    public ?string $massPdfDownloadUrl = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroInstitucionId(): void
    {
        $this->resetPage();
        $this->filtroProgramaEstudioId = null;
    }

    public function updatingFiltroProgramaEstudioId(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    // ── Eliminar ─────────────────────────────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $this->estudianteIdParaEliminar = $id;
    }

    public function deleteEstudiante(): void
    {
        if (! $this->estudianteIdParaEliminar) {
            return;
        }

        $estudiante = Estudiante::find($this->estudianteIdParaEliminar);
        if ($estudiante) {
            $estudiante->delete();
            Flux::toast(text: 'Estudiante eliminado correctamente.', variant: 'success');
        }

        $this->estudianteIdParaEliminar = null;
        $this->dispatch('close-modal', name: 'modal-delete-estudiante');
    }

    // ── Ver carnet PDF en iframe ──────────────────────────────────────────
    public function verCarnetPdf(int $id): void
    {
        $this->estudianteIdCarnet = $id;
        $this->pdfUrl = route('carnets.pdf.stream', $id);
        $this->dispatch('open-modal', name: 'modal-carnet-pdf');
    }

    public function cerrarCarnet(): void
    {
        $this->pdfUrl = null;
        $this->estudianteIdCarnet = null;
    }

    // ── Carnets masivos en iframe ─────────────────────────────────────────
    public function verCarnetsMasivos(): void
    {
        $params = array_filter([
            'institucion_id' => $this->filtroInstitucionId,
            'programa_estudio_id' => $this->filtroProgramaEstudioId,
            'search' => $this->search ?: null,
        ]);

        $this->massPdfUrl = route('carnets.pdf.stream-masivo', $params);
        $this->massPdfDownloadUrl = route('carnets.pdf.masivo', $params);
        $this->showMassCarnetModal = true;
        $this->dispatch('open-modal', name: 'modal-carnets-masivos');
    }

    public function cerrarCarnetsMasivos(): void
    {
        $this->massPdfUrl = null;
        $this->massPdfDownloadUrl = null;
        $this->showMassCarnetModal = false;
    }

    // ── Query ─────────────────────────────────────────────────────────────
    protected function getEstudiantes()
    {
        $query = Estudiante::with(['institucion', 'programaEstudio', 'carnet']);

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('nombres', 'like', "%{$this->search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$this->search}%")
                    ->orWhere('apellido_materno', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%")
                    ->orWhere('celular', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroInstitucionId) {
            $query->where('institucion_id', $this->filtroInstitucionId);
        }

        if ($this->filtroProgramaEstudioId) {
            $query->where('programa_estudio_id', $this->filtroProgramaEstudioId);
        }

        return $query->latest('creado_en')->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.estudiante.estudiante-table', [
            'estudiantes' => $this->getEstudiantes(),
            'instituciones' => Institucion::where('activo', true)->get(),
            'programasEstudio' => ProgramaEstudio::where('activo', true)
                ->when($this->filtroInstitucionId, fn ($q) => $q->where('institucion_id', $this->filtroInstitucionId))
                ->get(),
        ]);
    }
}
