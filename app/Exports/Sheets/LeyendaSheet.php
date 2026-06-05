<?php

namespace App\Exports\Sheets;

use App\Models\Institucion;
use App\Models\ProgramaEstudio;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeyendaSheet implements ShouldAutoSize, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Leyenda';
    }

    public function styles(Worksheet $sheet): void
    {
        $sheet->setCellValue('A1', 'LEYENDA - CÓDIGOS DE REFERENCIA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FF1F4E79'],
                'name' => 'Calibri',
            ],
        ]);
        $sheet->getRowDimension('1')->setRowHeight(30);

        $sheet->setCellValue('A2', 'Consulte esta hoja para conocer los IDs de cada Institución y Programa de Estudio.');
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 10,
                'color' => ['argb' => 'FF808080'],
                'name' => 'Calibri',
            ],
        ]);

        $this->agregarSeccionInstituciones($sheet);
        $this->agregarSeccionProgramas($sheet);
    }

    private function agregarSeccionInstituciones(Worksheet $sheet): void
    {
        $startRow = 4;

        $sheet->setCellValue("A{$startRow}", 'INSTITUCIONES');
        $sheet->mergeCells("A{$startRow}:B{$startRow}");
        $sheet->getStyle("A{$startRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF'],
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2E75B6'],
            ],
        ]);

        $headerRow = $startRow + 1;
        $sheet->setCellValue("A{$headerRow}", 'ID');
        $sheet->setCellValue("B{$headerRow}", 'Nombre');
        $sheet->getStyle("A{$headerRow}:B{$headerRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4472C4'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $instituciones = Institucion::where('activo', true)->orderBy('nombre')->get(['id', 'nombre']);
        $row = $headerRow + 1;
        foreach ($instituciones as $inst) {
            $sheet->setCellValueExplicit("A{$row}", (string) $inst->id, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$row}", $inst->nombre);

            if (($row - $headerRow) % 2 === 0) {
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE8F0FE'],
                    ],
                ]);
            }

            $row++;
        }

        $instEndRow = $row - 1;
        $sheet->getStyle("A{$startRow}:B{$instEndRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFB4C6E7'],
                ],
            ],
        ]);
    }

    private function agregarSeccionProgramas(Worksheet $sheet): void
    {
        $instituciones = Institucion::where('activo', true)->orderBy('nombre')->get(['id', 'nombre']);
        $progStartRow = 4 + $instituciones->count() + 3;

        $sheet->setCellValue("A{$progStartRow}", 'PROGRAMAS DE ESTUDIO');
        $sheet->mergeCells("A{$progStartRow}:D{$progStartRow}");
        $sheet->getStyle("A{$progStartRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF'],
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2E75B6'],
            ],
        ]);

        $progHeaderRow = $progStartRow + 1;
        $sheet->setCellValue("A{$progHeaderRow}", 'ID');
        $sheet->setCellValue("B{$progHeaderRow}", 'Nombre');
        $sheet->setCellValue("C{$progHeaderRow}", 'Institución ID');
        $sheet->setCellValue("D{$progHeaderRow}", 'Institución');
        $sheet->getStyle("A{$progHeaderRow}:D{$progHeaderRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
                'name' => 'Calibri',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4472C4'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $programas = ProgramaEstudio::where('activo', true)
            ->with('institucion:id,nombre')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'institucion_id']);

        $row = $progHeaderRow + 1;
        foreach ($programas as $prog) {
            $sheet->setCellValueExplicit("A{$row}", (string) $prog->id, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$row}", $prog->nombre);
            $sheet->setCellValueExplicit("C{$row}", (string) $prog->institucion_id, DataType::TYPE_STRING);
            $sheet->setCellValue("D{$row}", $prog->institucion?->nombre ?? '');

            if (($row - $progHeaderRow) % 2 === 0) {
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE8F0FE'],
                    ],
                ]);
            }

            $row++;
        }

        $progEndRow = $row - 1;
        $sheet->getStyle("A{$progStartRow}:D{$progEndRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFB4C6E7'],
                ],
            ],
        ]);

        $sheet->freezePane('A3');
    }
}
