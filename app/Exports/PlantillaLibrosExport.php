<?php

namespace App\Exports;

use App\Exports\Sheets\DatosLibrosSheet;
use App\Exports\Sheets\LeyendaLibrosSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlantillaLibrosExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DatosLibrosSheet,
            new LeyendaLibrosSheet,
        ];
    }
}
