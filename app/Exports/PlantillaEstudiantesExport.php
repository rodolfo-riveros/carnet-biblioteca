<?php

namespace App\Exports;

use App\Exports\Sheets\DatosEstudiantesSheet;
use App\Exports\Sheets\LeyendaSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlantillaEstudiantesExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DatosEstudiantesSheet,
            new LeyendaSheet,
        ];
    }
}
