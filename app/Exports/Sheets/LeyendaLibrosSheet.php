<?php

namespace App\Exports\Sheets;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeyendaLibrosSheet implements ShouldAutoSize, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Leyenda';
    }

    public function styles(Worksheet $sheet): void
    {
        $sheet->setCellValue('A1', 'LEYENDA - CÓDIGOS DE REFERENCIA');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FF1F4E79'],
                'name' => 'Calibri',
            ],
        ]);
        $sheet->getRowDimension('1')->setRowHeight(30);

        $sheet->setCellValue('A2', 'Consulte esta hoja para conocer los IDs de cada Categoría.');
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 10,
                'color' => ['argb' => 'FF808080'],
                'name' => 'Calibri',
            ],
        ]);

        $this->agregarSeccionCategorias($sheet);
    }

    private function agregarSeccionCategorias(Worksheet $sheet): void
    {
        $startRow = 4;

        $sheet->setCellValue("A{$startRow}", 'CATEGORÍAS');
        $sheet->mergeCells("A{$startRow}:C{$startRow}");
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
        $sheet->setCellValue("C{$headerRow}", 'Descripción');
        $sheet->getStyle("A{$headerRow}:C{$headerRow}")->applyFromArray([
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

        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get(['id', 'nombre', 'descripcion']);
        $row = $headerRow + 1;
        foreach ($categorias as $cat) {
            $sheet->setCellValueExplicit("A{$row}", (string) $cat->id, DataType::TYPE_STRING);
            $sheet->setCellValue("B{$row}", $cat->nombre);
            $sheet->setCellValue("C{$row}", $cat->descripcion ?? '');

            if (($row - $headerRow) % 2 === 0) {
                $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE8F0FE'],
                    ],
                ]);
            }

            $row++;
        }

        $endRow = $row - 1;
        $sheet->getStyle("A{$startRow}:C{$endRow}")->applyFromArray([
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
