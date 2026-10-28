<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $producto = $this->route('producto');

        return $producto instanceof Producto && Gate::allows('update', $producto);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'precio' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
            'existencia' => ['required', 'integer', 'min:0', 'max:999999'],
            'usuario_id' => ['required', 'integer', 'exists:usuarios,id'],
            'categorias' => ['required', 'array', 'min:1'],
            'categorias.*' => ['integer', 'distinct', 'exists:categorias,id'],
        ];
    }

    public function messages(): array
    {
        return (new StoreProductoRequest)->messages();
    }
}
