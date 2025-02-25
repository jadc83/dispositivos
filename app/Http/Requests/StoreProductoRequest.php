<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'nombre' => 'required|string|max:255|unique:productos,nombre',
                'precio' => 'required|numeric|between:0,999999.99',
        ];
    }

    public function messages(): array
    {
        return [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
                'nombre.unique' => 'El producto ya existe en la base de datos',
                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric' => 'El precio debe ser un número válido.',
                'precio.between' => 'El precio debe estar entre 0 y 999999.99.',
        ];
    }
}
