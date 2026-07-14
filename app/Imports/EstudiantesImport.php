<?php

namespace App\Imports;

use App\Models\Carnet;
use App\Models\Estudiante;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToCollection, WithHeadingRow
{
    public array $errores = [];

    public int $importados = 0;

    public int $fallidos = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            try {
                $data = $row->toArray();
                $dni = trim($data['dni'] ?? '');
                $nombres = trim($data['nombres'] ?? '');
                $apellidoPaterno = trim($data['apellido_paterno'] ?? '');
                $apellidoMaterno = trim($data['apellido_materno'] ?? '');

                if (empty($dni) && empty($nombres) && empty($apellidoPaterno) && empty($apellidoMaterno)) {
                    continue;
                }

                if (empty($dni) || ! preg_match('/^\d{8}$/', $dni)) {
                    $this->errores[] = 'Fila '.($index + 2).': DNI inválido ('.$dni.')';
                    $this->fallidos++;

                    continue;
                }

                if (Estudiante::where('dni', $dni)->exists()) {
                    $this->errores[] = 'Fila '.($index + 2).': DNI '.$dni.' ya existe';
                    $this->fallidos++;

                    continue;
                }

                $estudiante = Estudiante::create([
                    'dni' => $dni,
                    'nombres' => trim($data['nombres'] ?? ''),
                    'apellido_paterno' => trim($data['apellido_paterno'] ?? ''),
                    'apellido_materno' => trim($data['apellido_materno'] ?? ''),
                    'celular' => trim($data['celular'] ?? ''),
                    'celular_alternativo' => ! empty($data['celular_alternativo']) ? trim($data['celular_alternativo']) : null,
                    'email' => ! empty($data['email']) ? trim($data['email']) : null,
                    'institucion_id' => (int) ($data['institucion_id'] ?? 0),
                    'programa_estudio_id' => ! empty($data['programa_estudio_id']) ? (int) $data['programa_estudio_id'] : null,
                    'codigo_alumno' => ! empty($data['codigo_alumno']) ? trim($data['codigo_alumno']) : null,
                    'anio_ingreso' => ! empty($data['anio_ingreso']) ? (int) $data['anio_ingreso'] : null,
                    'anio_egreso' => ! empty($data['anio_egreso']) ? (int) $data['anio_egreso'] : null,
                    'estado' => 'activo',
                ]);

                Carnet::create([
                    'estudiante_id' => $estudiante->id,
                    'numero_carnet' => $estudiante->codigo_alumno ?? 'CAR-'.date('Y').'-'.str_pad($estudiante->id, 5, '0', STR_PAD_LEFT),
                    'codigo_barras' => 'CB'.date('Ymd').str_pad($estudiante->id, 5, '0', STR_PAD_LEFT),
                    'fecha_emision' => now(),
                    'fecha_vencimiento' => now()->addYears(5),
                    'creado_por' => auth()->id(),
                ]);

                $this->importados++;
            } catch (\Exception $e) {
                $this->errores[] = 'Fila '.($index + 2).': '.$e->getMessage();
                $this->fallidos++;
            }
        }
    }
}
