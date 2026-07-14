<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use Barryvdh\DomPDF\Facade\Pdf;

class LibroBarcodeDownloadController extends Controller
{
    public function downloadEjemplar(int $id)
    {
        $ejemplar = Ejemplar::with('libro:id,titulo,codigo_interno')->findOrFail($id);

        $codigoBarra = $ejemplar->codigo_barras;

        if (empty($codigoBarra)) {
            return redirect()->back()->with('error', 'Este ejemplar no tiene código de barras asignado.');
        }

        $pdf = Pdf::loadView('pdf.barcode-single', [
            'ejemplar' => $ejemplar,
            'codigo_barra' => $codigoBarra,
            'titulo' => $ejemplar->libro?->titulo ?? 'Libro sin ID',
            'codigo_interno' => $ejemplar->libro?->codigo_interno ?? '—',
            'numero_copia' => $ejemplar->numero_copia,
        ]);

        return $pdf->download('codigo-barras-'.$ejemplar->id.'.pdf');
    }

    public function downloadLibro(int $libroId)
    {
        $ejemplares = Ejemplar::with('libro:id,titulo,codigo_interno')
            ->where('libro_id', $libroId)
            ->whereNotNull('codigo_barras')
            ->where('codigo_barras', '!=', '')
            ->orderBy('numero_copia')
            ->get();

        if ($ejemplares->isEmpty()) {
            return redirect()->back()->with('error', 'Este libro no tiene ejemplares con código de barras.');
        }

        $data = [];
        foreach ($ejemplares as $ejemplar) {
            $data[] = [
                'id' => $ejemplar->id,
                'libro_titulo' => $ejemplar->libro?->titulo ?? 'Sin título',
                'libro_codigo_interno' => $ejemplar->libro?->codigo_interno ?? '—',
                'numero_copia' => $ejemplar->numero_copia,
                'barcode' => $ejemplar->codigo_barras,
                'codigo_barras' => $ejemplar->codigo_barras,
            ];
        }

        $pdf = Pdf::loadView('pdf.barcode-labels', ['ejemplares' => $data]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('codigos-barras-libro-'.$libroId.'.pdf');
    }

    public function downloadEjemplaresMasivo()
    {
        $ids = request('ids', '');
        $idArray = array_filter(explode(',', $ids), 'is_numeric');

        if (empty($idArray)) {
            return redirect()->back()->with('error', 'No se especificaron ejemplares.');
        }

        $ejemplares = Ejemplar::with('libro:id,titulo,codigo_interno')
            ->whereIn('id', $idArray)
            ->whereNotNull('codigo_barras')
            ->where('codigo_barras', '!=', '')
            ->orderBy('id')
            ->get();

        if ($ejemplares->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron ejemplares con código de barras.');
        }

        $data = [];
        foreach ($ejemplares as $ejemplar) {
            $data[] = [
                'id' => $ejemplar->id,
                'libro_titulo' => $ejemplar->libro?->titulo ?? 'Sin título',
                'libro_codigo_interno' => $ejemplar->libro?->codigo_interno ?? '—',
                'numero_copia' => $ejemplar->numero_copia,
                'barcode' => $ejemplar->codigo_barras,
                'codigo_barras' => $ejemplar->codigo_barras,
            ];
        }

        $pdf = Pdf::loadView('pdf.barcode-labels', ['ejemplares' => $data]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('codigos-barras-seleccionados.pdf');
    }
}
