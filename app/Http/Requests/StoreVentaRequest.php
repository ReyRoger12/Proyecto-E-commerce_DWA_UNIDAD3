<?php

namespace App\Http\Requests;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->filled('cliente_id')) {
            return Gate::allows('create', Venta::class);
        }

        return Gate::allows('createFor', [
            Venta::class,
            (int) $this->input('cliente_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'vendedor_id' => ['required', 'integer', 'exists:usuarios,id'],
            'cliente_id' => ['required', 'integer', 'exists:usuarios,id', 'different:vendedor_id'],
            'fecha' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.exists' => 'El producto seleccionado ya no existe.',
            'vendedor_id.exists' => 'El vendedor seleccionado ya no existe.',
            'cliente_id.exists' => 'El cliente seleccionado ya no existe.',
            'cliente_id.different' => 'El cliente y el vendedor deben ser usuarios distintos.',
            'fecha.date' => 'La fecha de la venta no es válida.',
            'total.min' => 'El total debe ser mayor a cero.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $producto = Producto::query()->find($this->integer('producto_id'));

                if ($producto && $producto->usuario_id !== $this->integer('vendedor_id')) {
                    $validator->errors()->add(
                        'vendedor_id',
                        'El vendedor no corresponde al producto seleccionado.',
                    );
                }
            },
        ];
    }
}
