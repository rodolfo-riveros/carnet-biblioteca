<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaEstudiantesExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'DNI',
            'Nombres',
            'Apellido Paterno',
            'Apellido Materno',
            'Celular',
            'Celular Alternativo',
            'Email',
            'Institución ID',
            'Programa Estudio ID',
            'Código Alumno',
            'Año Ingreso',
            'Año Egreso',
        ];
    }
}
