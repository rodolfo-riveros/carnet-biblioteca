<?php

namespace App\Console\Commands;

use App\Models\AlertaDevolucion;
use App\Models\Prestamo;
use Illuminate\Console\Command;

class GenerarAlertasDevolucion extends Command
{
    protected $signature = 'alertas:generar';

    protected $description = 'Genera alertas para préstamos vencidos';

    public function handle(): void
    {
        $vencidos = Prestamo::with('carnet.estudiante')
            ->where('estado', 'prestado')
            ->whereDate('fecha_devolucion_prevista', '<', now()->startOfDay())
            ->get();

        $count = 0;

        foreach ($vencidos as $prestamo) {
            $dias = $prestamo->dias_vencido;

            $tipo = match (true) {
                $dias === 0 => 'vencimiento_hoy',
                $dias <= 3 => 'devolucion_vencida',
                $dias <= 7 => 'segundo_aviso',
                default => 'tercer_aviso',
            };

            $yaExiste = AlertaDevolucion::where('prestamo_id', $prestamo->id)
                ->where('tipo_alerta', $tipo)
                ->exists();

            if ($yaExiste) {
                continue;
            }

            $estudiante = $prestamo->carnet->estudiante;

            AlertaDevolucion::create([
                'prestamo_id' => $prestamo->id,
                'carnet_id' => $prestamo->carnet_id,
                'tipo_alerta' => $tipo,
                'mensaje' => "El estudiante {$estudiante->nombres} {$estudiante->apellido_paterno} tiene {$dias} día(s) de retraso en la devolución de libros.",
                'celular_destino' => $estudiante->celular,
                'dias_vencido' => $dias,
            ]);

            $count++;
        }

        $this->info("{$count} alerta(s) generada(s).");
    }
}
