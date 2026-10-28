<?php

namespace App\Listeners;

use App\Events\VentaCreada;
use Illuminate\Support\Facades\Log;

class RegistrarVentaEnBitacora
{
    public function handle(VentaCreada $event): void
    {
        Log::channel('ventas')->info('Venta creada', [
            'venta_id' => $event->venta->id,
            'producto_id' => $event->venta->producto_id,
            'cliente_id' => $event->venta->cliente_id,
            'vendedor_id' => $event->venta->vendedor_id,
            'total' => $event->venta->total,
            'ip' => request()->ip(),
        ]);
    }
}
