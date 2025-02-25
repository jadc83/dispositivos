<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdenadorRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'aula_id' => 'exists:aulas,id'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del equipo es obligatorio',
            'nombre.max' => 'La longitud del nombre no puede exceder los 255 caracteres',
            'modelo.required' => 'El nombre del equipo es obligatorio',
            'modelo.max' => 'La longitud del nombre no puede exceder los 255 caracteres',
        ];
    }
}
