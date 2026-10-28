<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('create', Producto::class);
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
        return [
            'nombre.required' => 'Escribe el nombre del producto.',
            'descripcion.required' => 'Escribe una descripción.',
            'precio.required' => 'Indica el precio.',
            'precio.min' => 'El precio debe ser mayor a cero.',
            'existencia.required' => 'Indica la existencia disponible.',
            'usuario_id.required' => 'Selecciona un vendedor.',
            'usuario_id.exists' => 'El vendedor seleccionado no existe.',
            'categorias.required' => 'Selecciona al menos una categoría.',
        ];
    }
}
