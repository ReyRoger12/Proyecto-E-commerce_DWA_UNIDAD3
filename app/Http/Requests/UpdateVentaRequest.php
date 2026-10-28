<?php

namespace App\Http\Requests;

use App\Models\Venta;
use Illuminate\Support\Facades\Gate;

class UpdateVentaRequest extends StoreVentaRequest
{
    public function authorize(): bool
    {
        $venta = $this->route('venta');

        return $venta instanceof Venta && Gate::allows('update', $venta);
    }
}
