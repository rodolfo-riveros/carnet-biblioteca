<?php

namespace App\Imports;

use App\Models\Ejemplar;
use App\Models\Libro;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LibrosImport implements ToCollection, WithHeadingRow
{
    public array $errores = [];

    public int $importados = 0;

    public int $fallidos = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            try {
                $data = $row->toArray();
                $titulo = trim($data['titulo'] ?? '');
                $autor = trim($data['autor'] ?? '');

                if (empty($titulo) && empty($autor)) {
                    continue;
                }

                if (empty($titulo) || empty($autor)) {
                    $this->errores[] = 'Fila '.($index + 2).': Título y Autor son obligatorios.';
                    $this->fallidos++;

                    continue;
                }

                $codigoInterno = ! empty($data['codigo_interno']) ? trim($data['codigo_interno']) : null;

                if ($codigoInterno && Libro::where('codigo_interno', $codigoInterno)->exists()) {
                    $this->errores[] = 'Fila '.($index + 2).': Código Interno "'.$codigoInterno.'" ya existe.';
                    $this->fallidos++;

                    continue;
                }

                if (! $codigoInterno) {
                    $maxId = Libro::max('id') ?? 0;
                    $codigoInterno = 'LIB-'.str_pad($maxId + $this->importados + 1, 5, '0', STR_PAD_LEFT);
                }

                $libro = Libro::create([
                    'titulo' => $titulo,
                    'subtitulo' => ! empty($data['subtitulo']) ? trim($data['subtitulo']) : null,
                    'autor' => $autor,
                    'co_autores' => ! empty($data['co_autores']) ? trim($data['co_autores']) : null,
                    'isbn' => ! empty($data['isbn']) ? trim($data['isbn']) : null,
                    'codigo_interno' => $codigoInterno,
                    'editorial' => ! empty($data['editorial']) ? trim($data['editorial']) : null,
                    'lugar_publicacion' => ! empty($data['lugar_publicacion']) ? trim($data['lugar_publicacion']) : null,
                    'anio_publicacion' => ! empty($data['anio_publicacion']) ? (int) $data['anio_publicacion'] : null,
                    'edicion' => ! empty($data['edicion']) ? trim($data['edicion']) : null,
                    'paginas' => ! empty($data['paginas']) ? (int) $data['paginas'] : null,
                    'idioma' => ! empty($data['idioma']) ? trim($data['idioma']) : 'Español',
                    'descripcion' => ! empty($data['descripcion']) ? trim($data['descripcion']) : null,
                    'palabras_clave' => ! empty($data['palabras_clave']) ? trim($data['palabras_clave']) : null,
                    'categoria_id' => ! empty($data['categoria_id']) ? (int) $data['categoria_id'] : null,
                    'ubicacion_estante' => ! empty($data['ubicacion_estante']) ? trim($data['ubicacion_estante']) : null,
                    'signatura' => ! empty($data['signatura']) ? trim($data['signatura']) : null,
                ]);

                Ejemplar::create([
                    'libro_id' => $libro->id,
                    'numero_copia' => '001',
                    'codigo_barras' => 'CB'.date('Ymd').str_pad($libro->id, 5, '0', STR_PAD_LEFT),
                    'estado' => 'disponible',
                ]);

                $this->importados++;
            } catch (\Exception $e) {
                $this->errores[] = 'Fila '.($index + 2).': '.$e->getMessage();
                $this->fallidos++;
            }
        }
    }
}
