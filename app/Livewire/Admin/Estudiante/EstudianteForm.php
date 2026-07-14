<?php

namespace App\Livewire\Admin\Estudiante;

use App\Models\Carnet;
use App\Models\Estudiante;
use App\Models\Institucion;
use App\Models\ProgramaEstudio;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EstudianteForm extends Component
{
    use WithFileUploads;

    public ?int $estudianteId = null;

    public bool $isEditMode = false;

    public string $dni = '';

    public string $nombres = '';

    public string $apellido_paterno = '';

    public string $apellido_materno = '';

    public string $celular = '';

    public ?string $celular_alternativo = null;

    public ?string $email = null;

    public $foto = null;

    public ?string $foto_ruta = null;

    public ?string $foto_ruta_original = null;

    public bool $fotoModificada = false;

    public ?int $institucion_id = null;

    public ?int $programa_estudio_id = null;

    public ?string $codigo_alumno = null;

    public ?string $anio_ingreso = null;

    public ?string $anio_egreso = null;

    public string $estado = 'activo';

    public ?string $observaciones = null;

    public bool $consultandoDni = false;

    public ?int $carnet_id = null;

    public string $carnet_numero = '';

    public string $carnet_codigo_barras = '';

    public string $carnet_fecha_emision = '';

    public string $carnet_fecha_vencimiento = '';

    public bool $carnet_existe = false;

    protected function rules(): array
    {
        $rules = [
            'dni' => [
                'required',
                'string',
                'digits:8',
                'unique:estudiantes,dni'.($this->estudianteId ? ",{$this->estudianteId}" : ''),
            ],
            'nombres' => ['required', 'string', 'min:2', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'min:2', 'max:100'],
            'apellido_materno' => ['required', 'string', 'min:2', 'max:100'],
            'celular' => ['required', 'string', 'max:20'],
            'celular_alternativo' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'foto' => $this->foto ? ['image', 'mimes:jpeg,png,jpg', 'max:1024'] : ['nullable'],
            'foto_ruta' => ['nullable', 'string', 'max:255'],
            'institucion_id' => ['required', 'exists:institucions,id'],
            'programa_estudio_id' => ['nullable', 'exists:programa_estudios,id'],
            'codigo_alumno' => ['nullable', 'string', 'max:50'],
            'anio_ingreso' => ['nullable', 'digits:4'],
            'anio_egreso' => ['nullable', 'digits:4'],
            'estado' => ['required', 'in:activo,suspendido,bloqueado'],
            'observaciones' => ['nullable', 'string', 'max:5000'],
        ];

        if ($this->carnet_existe) {
            $rules['carnet_fecha_emision'] = ['required', 'date'];
            $rules['carnet_fecha_vencimiento'] = ['required', 'date', 'after_or_equal:carnet_fecha_emision'];
        }

        return $rules;
    }

    protected array $messages = [
        'dni.required' => 'El DNI es obligatorio.',
        'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
        'dni.unique' => 'Ya existe un estudiante con ese DNI.',
        'nombres.required' => 'Los nombres son obligatorios.',
        'nombres.min' => 'Los nombres deben tener al menos 2 caracteres.',
        'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
        'apellido_paterno.min' => 'El apellido paterno debe tener al menos 2 caracteres.',
        'apellido_materno.required' => 'El apellido materno es obligatorio.',
        'apellido_materno.min' => 'El apellido materno debe tener al menos 2 caracteres.',
        'celular.required' => 'El celular es obligatorio.',
        'email.email' => 'Ingrese un correo electrónico válido.',
        'institucion_id.required' => 'Debe seleccionar una institución.',
        'institucion_id.exists' => 'La institución seleccionada no existe.',
        'programa_estudio_id.exists' => 'El programa de estudio seleccionado no existe.',
        'anio_ingreso.digits' => 'El año de ingreso debe tener 4 dígitos.',
        'anio_egreso.digits' => 'El año de egreso debe tener 4 dígitos.',
        'estado.required' => 'Debe seleccionar un estado.',
        'estado.in' => 'El estado seleccionado no es válido.',
        'carnet_fecha_emision.required_with' => 'La fecha de emisión del carnet es obligatoria.',
        'carnet_fecha_emision.date' => 'Ingrese una fecha de emisión válida.',
        'carnet_fecha_vencimiento.required_with' => 'La fecha de vencimiento del carnet es obligatoria.',
        'carnet_fecha_vencimiento.date' => 'Ingrese una fecha de vencimiento válida.',
        'carnet_fecha_vencimiento.after_or_equal' => 'El vencimiento debe ser igual o posterior a la emisión.',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $estudiante = Estudiante::findOrFail($id);
            $this->estudianteId = $id;
            $this->isEditMode = true;
            $this->dni = $estudiante->dni;
            $this->nombres = $estudiante->nombres;
            $this->apellido_paterno = $estudiante->apellido_paterno;
            $this->apellido_materno = $estudiante->apellido_materno;
            $this->celular = $estudiante->celular;
            $this->celular_alternativo = $estudiante->celular_alternativo;
            $this->email = $estudiante->email;
            $this->foto_ruta = $estudiante->foto_ruta;
            $this->foto_ruta_original = $estudiante->foto_ruta;
            $this->fotoModificada = false;
            $this->institucion_id = $estudiante->institucion_id;
            $this->programa_estudio_id = $estudiante->programa_estudio_id;
            $this->codigo_alumno = $estudiante->codigo_alumno;
            $this->anio_ingreso = $estudiante->anio_ingreso ? (string) $estudiante->anio_ingreso : null;
            $this->anio_egreso = $estudiante->anio_egreso ? (string) $estudiante->anio_egreso : null;
            $this->estado = $estudiante->estado;
            $this->observaciones = $estudiante->observaciones;

            $carnet = Carnet::where('estudiante_id', $id)->first();
            if ($carnet) {
                $this->carnet_existe = true;
                $this->carnet_id = $carnet->id;
                $this->carnet_numero = $carnet->numero_carnet;
                $this->carnet_codigo_barras = $carnet->codigo_barras;
                $this->carnet_fecha_emision = $carnet->fecha_emision->format('Y-m-d');
                $this->carnet_fecha_vencimiento = $carnet->fecha_vencimiento->format('Y-m-d');
            }
        }
    }

    public function updatedFoto(): void
    {
        $this->fotoModificada = true;
    }

    public function removeFoto(): void
    {
        $this->foto = null;
        $this->foto_ruta = null;
        $this->fotoModificada = true;
    }

    public function consultarDni(): void
    {
        $this->validateOnly('dni');

        $this->consultandoDni = true;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer sk_9399.MOL3KF5dqXF2d4pb0YYvH85qgVypiYzB',
                'Accept' => 'application/json',
                'Referer' => 'https://apis.net.pe/',
            ])
                ->timeout(15)
                ->withoutVerifying()
                ->get('https://api.apis.net.pe/v2/reniec/dni', [
                    'numero' => $this->dni,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->nombres = $data['nombres'] ?? '';
                $this->apellido_paterno = $data['apellidoPaterno'] ?? '';
                $this->apellido_materno = $data['apellidoMaterno'] ?? '';
                Flux::toast(text: 'DNI consultado correctamente.', variant: 'success');
            } else {
                Flux::toast(text: 'No se encontró información para el DNI ingresado.', variant: 'warning');
            }
        } catch (ConnectionException $e) {
            Flux::toast(text: 'Error de conexión al consultar DNI. Verifica tu conexión a internet.', variant: 'danger');
        } catch (RequestException $e) {
            Flux::toast(text: 'Error en la consulta del DNI: '.$e->response->status(), variant: 'danger');
        } catch (\Exception $e) {
            Flux::toast(text: 'Error al consultar DNI: '.$e->getMessage(), variant: 'danger');
        }

        $this->consultandoDni = false;
    }

    public function save(): void
    {
        $data = $this->validate();
        $data['anio_ingreso'] = empty($data['anio_ingreso']) ? null : (int) $data['anio_ingreso'];
        $data['anio_egreso'] = empty($data['anio_egreso']) ? null : (int) $data['anio_egreso'];

        if ($this->foto) {
            $data['foto_ruta'] = $this->foto->store('fotos', 'public');
            if ($this->isEditMode && $this->foto_ruta_original) {
                Storage::disk('public')->delete($this->foto_ruta_original);
            }
        } elseif ($this->fotoModificada && ! $this->foto) {
            $data['foto_ruta'] = null;
            if ($this->isEditMode && $this->foto_ruta_original) {
                Storage::disk('public')->delete($this->foto_ruta_original);
            }
        }

        unset($data['foto'], $data['carnet_fecha_emision'], $data['carnet_fecha_vencimiento'], $data['carnet_existe']);

        if ($this->isEditMode) {
            Estudiante::findOrFail($this->estudianteId)->update($data);

            if ($this->carnet_existe && $this->carnet_id) {
                Carnet::findOrFail($this->carnet_id)->update([
                    'fecha_emision' => $this->carnet_fecha_emision,
                    'fecha_vencimiento' => $this->carnet_fecha_vencimiento,
                ]);
            }

            Flux::toast(text: 'Estudiante actualizado correctamente.', variant: 'success');
        } else {
            $maxCode = Estudiante::where('codigo_alumno', 'like', date('Y').'-%')->max('codigo_alumno');
            if ($maxCode) {
                $lastNumber = (int) substr($maxCode, 5);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $data['codigo_alumno'] = date('Y').'-'.str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $estudiante = Estudiante::create($data);

            Carnet::create([
                'estudiante_id' => $estudiante->id,
                'numero_carnet' => $data['codigo_alumno'],
                'codigo_barras' => 'CB'.date('Ymd').str_pad($estudiante->id, 5, '0', STR_PAD_LEFT),
                'fecha_emision' => now(),
                'fecha_vencimiento' => now()->addYears(5),
                'creado_por' => auth()->id(),
            ]);

            Flux::toast(text: 'Estudiante registrado correctamente con su carnet.', variant: 'success');
            $this->reset([
                'dni', 'nombres', 'apellido_paterno', 'apellido_materno',
                'celular', 'celular_alternativo', 'email', 'foto', 'foto_ruta',
                'institucion_id', 'programa_estudio_id', 'codigo_alumno',
                'anio_ingreso', 'anio_egreso', 'observaciones',
            ]);
            $this->estado = 'activo';
        }

        $this->dispatch('estudiante-guardado');
        $this->redirectRoute('estudiantes.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.estudiante.estudiante-form', [
            'instituciones' => Institucion::where('activo', true)->get(),
            'programasEstudio' => ProgramaEstudio::where('activo', true)->get(),
        ]);
    }
}
