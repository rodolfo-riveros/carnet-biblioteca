<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DatosLibrosSheet implements FromArray, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'Título',
            'Subtítulo',
            'Autor',
            'Co-autores',
            'ISBN',
            'Código Interno',
            'Editorial',
            'Lugar Publicación',
            'Año Publicación',
            'Edición',
            'Páginas',
            'Idioma',
            'Descripción',
            'Palabras Clave',
            'Categoría ID',
            'Ubicación Estante',
            'Signatura',
        ];
    }

    public function title(): string
    {
        return 'Datos';
    }

    public function styles(Worksheet $sheet): void
    {
        $ultimaColumna = 'Q';

        $sheet->getStyle("A1:{$ultimaColumna}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F4E79'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getRowDimension('1')->setRowHeight(22);

        $sheet->freezePane('A2');

        $notaFila = 4;
        $sheet->setCellValue("A{$notaFila}", 'NOTA: Use la hoja "Leyenda" para consultar los IDs de Categorías. * Campos obligatorios: Título, Autor.');
        $sheet->getStyle("A{$notaFila}")->applyFromArray([
            'font' => [
                'italic' => true,
                'color' => ['argb' => 'FF808080'],
                'size' => 9,
                'name' => 'Calibri',
            ],
        ]);
    }
}
