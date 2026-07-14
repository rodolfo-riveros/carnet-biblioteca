<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeLabelController extends Controller
{
    public function export()
    {
        $ejemplares = Ejemplar::with('libro')
            ->whereNotNull('codigo_barras')
            ->where('codigo_barras', '!=', '')
            ->orderBy('creado_en', 'desc')
            ->get();

        if ($ejemplares->isEmpty()) {
            return redirect()->back()->with('error', 'No hay ejemplares con código de barras para exportar.');
        }

        $pdf = Pdf::loadView('pdf.barcode-labels', [
            'ejemplares' => $ejemplares,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('etiquetas-codigos-barras.pdf');
    }
}
