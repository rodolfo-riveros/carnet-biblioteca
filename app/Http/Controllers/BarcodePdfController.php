<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodePdfController extends Controller
{
    public function generatePdf($startId, $endId)
    {
        $ejemplares = Ejemplar::with('libro:id,titulo,codigo_interno')
            ->whereBetween('id', [$startId, $endId])
            ->orderBy('id')
            ->get();

        $data = [];
        foreach ($ejemplares as $ejemplar) {
            $displayBarcode = $ejemplar->codigo_barras;

            if (empty($displayBarcode) && $ejemplar->libro) {
                $ejemplar->barcode = 'CB'.date('Ymd').str_pad($ejemplar->id, 5, '0', STR_PAD_LEFT);
            } else {
                $ejemplar->barcode = $displayBarcode;
            }

            $data[] = [
                'id' => $ejemplar->id,
                'libro_titulo' => $ejemplar->libro->titulo ?? 'Libro sin ID',
                'libro_codigo_interno' => $ejemplar->libro->codigo_interno ?? '—',
                'numero_copia' => $ejemplar->numero_copia,
                'barcode' => $ejemplar->barcode,
                'estado' => $ejemplar->estado,
                'created_at' => $ejemplar->created_at,
            ];
        }

        $pdf = Pdf::loadView('pdf.barcode-labels', ['ejemplares' => $data]);

        return $pdf->download('codigos-de-barras.pdf');
    }

    public function streamPdf($startId, $endId)
    {
        $ejemplares = Ejemplar::with('libro:id,titulo,codigo_interno')
            ->whereBetween('id', [$startId, $endId])
            ->orderBy('id')
            ->get();

        $data = [];
        foreach ($ejemplares as $ejemplar) {
            $displayBarcode = $ejemplar->codigo_barras;

            if (empty($displayBarcode) && $ejemplar->libro) {
                $ejemplar->barcode = 'CB'.date('Ymd').str_pad($ejemplar->id, 5, '0', STR_PAD_LEFT);
            } else {
                $ejemplar->barcode = $displayBarcode;
            }

            $data[] = [
                'id' => $ejemplar->id,
                'libro_titulo' => $ejemplar->libro->titulo ?? 'Libro sin ID',
                'libro_codigo_interno' => $ejemplar->libro->codigo_interno ?? '—',
                'numero_copia' => $ejemplar->numero_copia,
                'barcode' => $ejemplar->barcode,
                'estado' => $ejemplar->estado,
                'created_at' => $ejemplar->created_at,
            ];
        }

        $pdf = Pdf::loadView('pdf.barcode-labels', ['ejemplares' => $data]);

        return $pdf->stream('codigos-de-barras.pdf');
    }
}
