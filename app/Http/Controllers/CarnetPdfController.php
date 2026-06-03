<?php

namespace App\Http\Controllers;

use App\Models\Carnet;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;

class CarnetPdfController extends Controller
{
    public function download($estudianteId)
    {
        $estudiante = Estudiante::with('institucion', 'programaEstudio')->findOrFail($estudianteId);
        $carnet = Carnet::where('estudiante_id', $estudianteId)->firstOrFail();

        $data = [
            'numero_carnet' => $carnet->numero_carnet,
            'codigo_barras' => $carnet->codigo_barras,
            'fecha_emision' => $carnet->fecha_emision->format('d/m/Y'),
            'fecha_vencimiento' => $carnet->fecha_vencimiento->format('d/m/Y'),
            'vencido' => $carnet->fecha_vencimiento->isPast(),
            'estudiante_id' => $estudiante->id,
            'estudiante_nombres' => $estudiante->nombres,
            'estudiante_apellido_paterno' => $estudiante->apellido_paterno,
            'estudiante_apellido_materno' => $estudiante->apellido_materno,
            'estudiante_dni' => $estudiante->dni,
            'estudiante_codigo' => $estudiante->codigo_alumno,
            'institucion' => $estudiante->institucion->nombre ?? '—',
            'programa' => $estudiante->programaEstudio->nombre ?? '—',
            'foto_ruta' => $estudiante->foto_ruta,
        ];

        $front = view('livewire.admin.carnet.carnet-front', compact('data'))->render();
        $back = view('livewire.admin.carnet.carnet-back', compact('data'))->render();

        $html = "
            <html><head>
            <meta charset='utf-8'>
            <style>
                @page { margin: 0; size: 85mm 108mm; }
                body { margin: 0; padding: 2mm; font-family: Helvetica, Arial, sans-serif; }
                .pair { display: flex; flex-direction: column; align-items: center; gap: 2mm; }
                .pair > div { margin-bottom: 2mm; }
            </style>
            </head><body>
            <div class='pair'>
                {$front}
                <div style='margin-top: 2mm;'>{$back}</div>
            </div>
            </body></html>
        ";

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper([0, 0, 240.94, 306.14], 'portrait');

        return $pdf->download("carnet_{$estudiante->dni}.pdf");
    }

    public function downloadMasivo()
    {
        $institucionId = request('institucion_id');
        $programaEstudioId = request('programa_estudio_id');
        $estado = request('estado');
        $search = request('search');

        $query = Estudiante::with('institucion', 'programaEstudio', 'carnet');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                    ->orWhere('apellido_paterno', 'like', "%{$search}%")
                    ->orWhere('apellido_materno', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($institucionId) {
            $query->where('institucion_id', $institucionId);
        }

        if ($programaEstudioId) {
            $query->where('programa_estudio_id', $programaEstudioId);
        }

        $estudiantes = $query->get();
        $html = '<html><head><meta charset="utf-8"><style>
            @page { margin: 0; size: 85mm 108mm; }
            body { margin: 0; padding: 2mm; font-family: Helvetica, Arial, sans-serif; }
            .pair { display: flex; flex-direction: column; align-items: center; gap: 2mm; margin-bottom: 3mm; }
            .page-break { page-break-after: always; }
        </style></head><body>';

        foreach ($estudiantes as $i => $estudiante) {
            $carnet = $estudiante->carnet;
            if (! $carnet) {
                continue;
            }

            $data = [
                'numero_carnet' => $carnet->numero_carnet,
                'codigo_barras' => $carnet->codigo_barras,
                'fecha_emision' => $carnet->fecha_emision->format('d/m/Y'),
                'fecha_vencimiento' => $carnet->fecha_vencimiento->format('d/m/Y'),
                'vencido' => $carnet->fecha_vencimiento->isPast(),
                'estudiante_id' => $estudiante->id,
                'estudiante_nombres' => $estudiante->nombres,
                'estudiante_apellido_paterno' => $estudiante->apellido_paterno,
                'estudiante_apellido_materno' => $estudiante->apellido_materno,
                'estudiante_dni' => $estudiante->dni,
                'estudiante_codigo' => $estudiante->codigo_alumno,
                'institucion' => $estudiante->institucion->nombre ?? '—',
                'programa' => $estudiante->programaEstudio->nombre ?? '—',
                'foto_ruta' => $estudiante->foto_ruta,
            ];

            $front = view('livewire.admin.carnet.carnet-front', compact('data'))->render();
            $back = view('livewire.admin.carnet.carnet-back', compact('data'))->render();

            $html .= "<div class='pair ".($i > 0 ? 'page-break' : '')."'>";
            $html .= $front;
            $html .= "<div style='margin-top:2mm;'>{$back}</div>";
            $html .= '</div>';
        }

        $html .= '</body></html>';

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper([0, 0, 240.94, 306.14], 'portrait');

        return $pdf->download('carnets_masivos.pdf');
    }
}
