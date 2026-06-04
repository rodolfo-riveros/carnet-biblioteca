<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Ejemplar;
use App\Models\Estudiante;
use App\Models\Institucion;
use App\Models\Libro;
use App\Models\ProgramaEstudio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Creando datos de prueba ---');

        // Instituciones
        $instituciones = [];
        foreach (['Universidad Nacional Mayor de San Marcos', 'Universidad Nacional de Ingeniería', 'Universidad San Martín', 'Instituto Peruano de Acción Empresarial'] as $nombre) {
            $instituciones[] = Institucion::create(['nombre' => $nombre, 'descripcion' => "Institución: {$nombre}", 'activo' => true]);
        }
        $this->command->info('✓ '.count($instituciones).' instituciones creadas');

        // Programas de Estudio
        $programas = [];
        $nombresProg = ['Ingeniería de Sistemas', 'Administración', 'Derecho', 'Psicología', 'Medicina', 'Arquitectura', 'Contabilidad', 'Educación'];
        foreach ($nombresProg as $nombre) {
            $programas[] = ProgramaEstudio::create([
                'nombre' => $nombre,
                'institucion_id' => $instituciones[array_rand($instituciones)]->id,
                'activo' => true,
            ]);
        }
        $this->command->info('✓ '.count($programas).' programas creados');

        // Categorías
        $cats = [];
        foreach (['Literatura Universal', 'Ciencia Ficción', 'Historia', 'Matemáticas', 'Física', 'Programación', 'Arte', 'Filosofía', 'Biología', 'Economía'] as $nombre) {
            $cats[] = Categoria::create(['nombre' => $nombre, 'descripcion' => "Categoría: {$nombre}", 'activo' => true]);
        }
        $this->command->info('✓ '.count($cats).' categorías creadas');

        // Estudiantes
        $estudiantes = [];
        $nombres = ['Carlos', 'María', 'José', 'Ana', 'Luis', 'Rosa', 'Pedro', 'Lucía', 'Jorge', 'Carmen'];
        $apellidos = ['García', 'Rodríguez', 'Martínez', 'López', 'Hernández', 'González', 'Pérez', 'Quispe', 'Huamán', 'Condori'];

        for ($i = 0; $i < 20; $i++) {
            $dni = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            $est = Estudiante::create([
                'dni' => $dni,
                'nombres' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apellidos[array_rand($apellidos)],
                'apellido_materno' => $apellidos[array_rand($apellidos)],
                'celular' => '9'.str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'email' => "estudiante{$i}@mail.com",
                'institucion_id' => $instituciones[array_rand($instituciones)]->id,
                'programa_estudio_id' => $programas[array_rand($programas)]->id,
                'codigo_alumno' => 'ALU-'.str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'estado' => 'activo',
            ]);

            $est->carnet()->create([
                'numero_carnet' => 'CAR-'.str_pad($est->id, 5, '0', STR_PAD_LEFT),
                'codigo_barras' => 'CB-'.Carbon::now()->format('Ymd').'-'.str_pad($est->id, 5, '0', STR_PAD_LEFT),
                'fecha_emision' => now(),
                'fecha_vencimiento' => now()->addYears(5),
                'creado_por' => 1,
            ]);

            $estudiantes[] = $est;
        }
        $this->command->info('✓ '.count($estudiantes).' estudiantes creados con carnets');

        // Libros
        $librosData = [
            ['titulo' => 'Cien Años de Soledad', 'autor' => 'Gabriel García Márquez', 'isbn' => '978-84-376-0494-7'],
            ['titulo' => 'El Principito', 'autor' => 'Antoine de Saint-Exupéry', 'isbn' => '978-01-5462-3480-2'],
            ['titulo' => '1984', 'autor' => 'George Orwell', 'isbn' => '978-04-5125-0342-5'],
            ['titulo' => 'Don Quijote de la Mancha', 'autor' => 'Miguel de Cervantes', 'isbn' => '978-84-206-0899-5'],
            ['titulo' => 'La Odisea', 'autor' => 'Homero', 'isbn' => '978-01-4654-7456-8'],
            ['titulo' => 'Harry Potter y la Piedra Filosofal', 'autor' => 'J.K. Rowling', 'isbn' => '978-84-7888-445-2'],
            ['titulo' => 'El Nombre del Viento', 'autor' => 'Patrick Rothfuss', 'isbn' => '978-84-9989-554-3'],
            ['titulo' => 'Fundación', 'autor' => 'Isaac Asimov', 'isbn' => '978-84-9759-273-8'],
            ['titulo' => 'El Señor de los Anillos', 'autor' => 'J.R.R. Tolkien', 'isbn' => '978-84-450-7173-8'],
            ['titulo' => 'La Sombra del Viento', 'autor' => 'Carlos Ruiz Zafón', 'isbn' => '978-84-9759-134-3'],
            ['titulo' => 'Introducción a la Programación', 'autor' => 'Luis Joyanes', 'isbn' => '978-84-4815-632-7'],
            ['titulo' => 'Estructuras de Datos', 'autor' => 'Mark Allen Weiss', 'isbn' => '978-84-7829-045-5'],
            ['titulo' => 'Física Universitaria', 'autor' => 'Young & Freedman', 'isbn' => '978-60-7123-456-1'],
            ['titulo' => 'Cálculo Diferencial', 'autor' => 'James Stewart', 'isbn' => '978-84-7829-056-1'],
            ['titulo' => 'Historia del Perú', 'autor' => 'Jorge Basadre', 'isbn' => '978-99-7123-045-6'],
        ];

        foreach ($librosData as $i => $ld) {
            $codigo = 'LIB-'.str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $libro = Libro::create([
                'titulo' => $ld['titulo'],
                'autor' => $ld['autor'],
                'isbn' => $ld['isbn'],
                'codigo_interno' => $codigo,
                'editorial' => ['Alfaguara', 'Planeta', 'Santillana', 'Pearson', 'McGraw Hill'][array_rand(['Alfaguara', 'Planeta', 'Santillana', 'Pearson', 'McGraw Hill'])],
                'anio_publicacion' => mt_rand(1990, 2024),
                'idioma' => 'Español',
                'categoria_id' => $cats[array_rand($cats)]->id,
                'paginas' => mt_rand(100, 800),
                'descripcion' => "Libro: {$ld['titulo']} - {$ld['autor']}",
            ]);

            // 2-4 ejemplares por libro
            $copias = mt_rand(2, 4);
            for ($c = 1; $c <= $copias; $c++) {
                Ejemplar::create([
                    'libro_id' => $libro->id,
                    'numero_copia' => str_pad($c, 3, '0', STR_PAD_LEFT),
                    'codigo_barras' => "CB-{$codigo}-{$c}",
                    'estado' => 'disponible',
                ]);
            }
        }
        $this->command->info('✓ '.count($librosData).' libros creados con ejemplares');

        $this->command->info('--- TestDataSeeder completado ---');
    }
}
