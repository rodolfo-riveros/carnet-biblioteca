<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DatosEstudiantesSheet implements FromArray, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
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

    public function title(): string
    {
        return 'Datos';
    }

    public function styles(Worksheet $sheet): void
    {
        $ultimaColumna = 'L';
        $filasFormateadas = 100;

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

        $sheet->getStyle("A2:{$ultimaColumna}{$filasFormateadas}")->applyFromArray([
            'font' => [
                'size' => 10,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD9D9D9'],
                ],
            ],
        ]);

        for ($row = 2; $row <= $filasFormateadas; $row++) {
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:{$ultimaColumna}{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF2F7FB'],
                    ],
                ]);
            }
        }

        $sheet->freezePane('A2');

        $sheet->getStyle('A2:A100')->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('E2:F100')->getNumberFormat()->setFormatCode('@');

        $notaFila = $filasFormateadas + 2;
        $sheet->setCellValue("A{$notaFila}", 'NOTA: Use la hoja "Leyenda" para consultar los IDs de Instituciones y Programas de Estudio.');
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
