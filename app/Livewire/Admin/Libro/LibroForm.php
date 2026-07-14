<?php

namespace App\Livewire\Admin\Libro;

use App\Models\Categoria;
use App\Models\Ejemplar;
use App\Models\Libro;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LibroForm extends Component
{
    use WithFileUploads;

    public ?int $libroId = null;

    public bool $isEditMode = false;

    public string $titulo = '';

    public ?string $subtitulo = null;

    public string $autor = '';

    public ?string $co_autores = null;

    public ?string $isbn = null;

    public ?string $codigo_interno = null;

    public ?string $editorial = null;

    public ?string $lugar_publicacion = null;

    public ?string $anio_publicacion = null;

    public ?string $edicion = null;

    public ?int $paginas = null;

    public string $idioma = 'Español';

    public ?string $descripcion = null;

    public ?string $palabras_clave = null;

    public ?int $categoria_id = null;

    public ?string $ubicacion_estante = null;

    public ?string $signatura = null;

    public $portada = null;

    public ?string $portada_ruta = null;

    public ?string $portada_ruta_original = null;

    public bool $portadaModificada = false;

    // ── Ejemplares ───────────────────────────────────────────────────────
    public $cantidadEjemplares = 1;

    public $ejemplares = [
        ['numero_copia' => '001', 'codigo_barras' => '', 'notas' => ''],
    ];

    protected function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:2', 'max:300'],
            'subtitulo' => ['nullable', 'string', 'max:300'],
            'autor' => ['required', 'string', 'min:2', 'max:200'],
            'co_autores' => ['nullable', 'string', 'max:300'],
            'isbn' => ['nullable', 'string', 'max:20'],
            'codigo_interno' => ['required', 'string', 'max:50', 'unique:libros,codigo_interno'.($this->libroId ? ",{$this->libroId}" : '')],
            'editorial' => ['nullable', 'string', 'max:150'],
            'lugar_publicacion' => ['nullable', 'string', 'max:100'],
            'anio_publicacion' => ['nullable', 'digits:4'],
            'edicion' => ['nullable', 'string', 'max:50'],
            'paginas' => ['nullable', 'integer', 'min:1'],
            'idioma' => ['required', 'string', 'max:50'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'palabras_clave' => ['nullable', 'string', 'max:500'],
            'categoria_id' => ['nullable', 'exists:categoria,id'],
            'ubicacion_estante' => ['nullable', 'string', 'max:50'],
            'signatura' => ['nullable', 'string', 'max:100'],
            'portada' => $this->portada ? ['image', 'mimes:jpeg,png,jpg', 'max:2048'] : ['nullable'],
            'ejemplares.*.codigo_barras' => ['nullable', 'string', 'max:100'],
            'ejemplares.*.notas' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected array $messages = [
        'titulo.required' => 'El título es obligatorio.',
        'titulo.min' => 'El título debe tener al menos 2 caracteres.',
        'autor.required' => 'El autor es obligatorio.',
        'codigo_interno.required' => 'El código interno es obligatorio.',
        'codigo_interno.unique' => 'Ya existe un libro con ese código interno.',
        'anio_publicacion.digits' => 'El año debe tener 4 dígitos.',
        'paginas.min' => 'Las páginas deben ser un número positivo.',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $libro = Libro::with('ejemplares')->findOrFail($id);
            $this->libroId = $id;
            $this->isEditMode = true;
            $this->titulo = $libro->titulo;
            $this->subtitulo = $libro->subtitulo;
            $this->autor = $libro->autor;
            $this->co_autores = $libro->co_autores;
            $this->isbn = $libro->isbn;
            $this->codigo_interno = $libro->codigo_interno;
            $this->editorial = $libro->editorial;
            $this->lugar_publicacion = $libro->lugar_publicacion;
            $this->anio_publicacion = $libro->anio_publicacion ? (string) $libro->anio_publicacion : null;
            $this->edicion = $libro->edicion;
            $this->paginas = $libro->paginas;
            $this->idioma = $libro->idioma;
            $this->descripcion = $libro->descripcion;
            $this->palabras_clave = $libro->palabras_clave;
            $this->categoria_id = $libro->categoria_id;
            $this->ubicacion_estante = $libro->ubicacion_estante;
            $this->signatura = $libro->signatura;
            $this->portada_ruta = $libro->portada_ruta;
            $this->portada_ruta_original = $libro->portada_ruta;

            $this->cantidadEjemplares = count($libro->ejemplares);
            $this->ejemplares = $libro->ejemplares->map(fn ($e) => [
                'id' => $e->id,
                'numero_copia' => $e->numero_copia,
                'codigo_barras' => $e->codigo_barras,
                'notas' => $e->notas,
            ])->toArray();
        }
    }

    public function updatedTitulo(): void
    {
        if (! $this->isEditMode) {
            $this->codigo_interno = $this->generarCodigoInterno();
            $this->isbn = $this->generarIsbn();
        }
    }

    public function updatedAutor(): void
    {
        if (! $this->isEditMode && empty($this->isbn)) {
            $this->isbn = $this->generarIsbn();
        }
    }

    public function updatedAnioPublicacion(): void
    {
        if (! $this->isEditMode && ! empty($this->isbn)) {
            $this->isbn = $this->generarIsbn();
        }
    }

    public function updatedCantidadEjemplares($value): void
    {
        if ($this->isEditMode) {
            return;
        }
        $this->generarEjemplares($this->ejemplares, (int) $value);
    }

    protected function generarEjemplares(array $actuales, int $cantidad): void
    {
        $current = collect($actuales);
        $nuevos = [];

        for ($i = 1; $i <= $cantidad; $i++) {
            $num = str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            $existente = $current->firstWhere('numero_copia', $num);
            if ($existente) {
                $nuevos[] = $existente;
            } else {
                $nuevos[] = [
                    'numero_copia' => $num,
                    'codigo_barras' => '',
                    'notas' => '',
                ];
            }
        }

        $this->ejemplares = $nuevos;
    }

    public function updatedPortada(): void
    {
        $this->portadaModificada = true;
    }

    public function removePortada(): void
    {
        $this->portada = null;
        $this->portada_ruta = null;
        $this->portadaModificada = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        $data['anio_publicacion'] = empty($data['anio_publicacion']) ? null : (int) $data['anio_publicacion'];

        if ($this->portada) {
            $data['portada_ruta'] = $this->portada->store('portadas', 'public');
            if ($this->isEditMode && $this->portada_ruta_original) {
                Storage::disk('public')->delete($this->portada_ruta_original);
            }
        } elseif ($this->portadaModificada && ! $this->portada) {
            $data['portada_ruta'] = null;
            if ($this->isEditMode && $this->portada_ruta_original) {
                Storage::disk('public')->delete($this->portada_ruta_original);
            }
        }

        unset($data['portada'], $data['cantidadEjemplares'], $data['ejemplares']);

        if ($this->isEditMode) {
            $libro = Libro::findOrFail($this->libroId);
            $libro->update($data);

            $existingIds = $libro->ejemplares()->pluck('id')->toArray();
            $keepIds = [];

            foreach ($this->ejemplares as $ej) {
                $ejData = [
                    'numero_copia' => $ej['numero_copia'],
                    'codigo_barras' => empty($ej['codigo_barras']) ? $this->generarCodigoBarras() : $ej['codigo_barras'],
                    'notas' => $ej['notas'] ?? null,
                ];

                if (! empty($ej['id'])) {
                    Ejemplar::findOrFail($ej['id'])->update($ejData);
                    $keepIds[] = $ej['id'];
                } else {
                    $libro->ejemplares()->create($ejData);
                }
            }

            $toDelete = array_diff($existingIds, $keepIds);
            Ejemplar::whereIn('id', $toDelete)->delete();

            Flux::toast(text: 'Libro actualizado correctamente.', variant: 'success');
        } else {
            if (empty($data['codigo_interno'])) {
                $maxId = Libro::max('id') ?? 0;
                $data['codigo_interno'] = 'LIB-'.str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);
            }

            $libro = Libro::create($data);

            foreach ($this->ejemplares as $ej) {
                if (! empty($ej['codigo_barras'])) {
                    $barcode = $ej['codigo_barras'];
                } else {
                    $barcode = $this->generarCodigoBarras();
                }
                $libro->ejemplares()->create([
                    'numero_copia' => $ej['numero_copia'],
                    'codigo_barras' => $barcode,
                    'notas' => $ej['notas'] ?? null,
                ]);
            }

            Flux::toast(text: 'Libro registrado correctamente con '.count($this->ejemplares).' ejemplares.', variant: 'success');

            $this->reset([
                'titulo', 'subtitulo', 'autor', 'co_autores', 'isbn',
                'codigo_interno', 'editorial', 'lugar_publicacion', 'anio_publicacion',
                'edicion', 'paginas', 'descripcion', 'palabras_clave', 'categoria_id',
                'ubicacion_estante', 'signatura', 'portada', 'portada_ruta',
                'ejemplares',
            ]);
            $this->idioma = 'Español';
            $this->cantidadEjemplares = 1;
        }

        $this->dispatch('libro-guardado');
        $this->redirectRoute('libros.index', navigate: true);
    }

    protected function generarCodigoInterno(): string
    {
        $words = preg_split('/\s+/', $this->titulo);
        $letters = '';
        foreach ($words as $w) {
            $w = trim($w);
            if (mb_strlen($w) > 2) {
                $letters .= mb_strtoupper(mb_substr($w, 0, 1));
            }
        }
        if (empty($letters)) {
            $letters = 'LIB';
        }
        $letters = mb_substr($letters, 0, 5);

        $count = Libro::where('codigo_interno', 'like', $letters.'-%')->count() + 1;

        return $letters.'-'.str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    protected function generarIsbn(): string
    {
        if ($this->isEditMode) {
            return $this->isbn ?? '';
        }

        $titleHash = abs(crc32($this->titulo.($this->autor ?? ''))) % 100000;
        $seq = (Libro::max('id') ?? 0) + 1;
        $year = $this->anio_publicacion ?? date('y');

        $base = '978'.substr($year, -2).str_pad($titleHash, 5, '0', STR_PAD_LEFT).str_pad($seq, 3, '0', STR_PAD_LEFT);

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $base[$i] * ($i % 2 === 0 ? 1 : 3);
        }
        $check = (10 - ($sum % 10)) % 10;

        return implode('-', [
            substr($base, 0, 3),
            substr($base, 3, 2),
            substr($base, 5, 5),
            substr($base, 10, 3),
            $check,
        ]);
    }

    protected function generarCodigoBarras(): string
    {
        $maxId = Libro::max('id') ?? 0;
        $maxEj = Ejemplar::max('id') ?? 0;
        $seq = max($maxId, $maxEj) + 1;

        return 'CB'.date('Ymd').str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('livewire.admin.libro.libro-form', [
            'categorias' => Categoria::where('activo', true)->get(),
        ]);
    }
}
