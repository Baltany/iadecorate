<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncidenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|string|in:tecnica,producto,envio,pago,otro',
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string|max:5000',
            'prioridad' => 'nullable|string|in:baja,media,alta,urgente'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'tipo.required' => 'Debes seleccionar el tipo de incidencia',
            'tipo.in' => 'El tipo de incidencia seleccionado no es válido',
            'asunto.required' => 'El asunto es obligatorio',
            'asunto.max' => 'El asunto no puede exceder 255 caracteres',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.max' => 'La descripción no puede exceder 5000 caracteres',
            'prioridad.in' => 'La prioridad seleccionada no es válida'
        ];
    }
}
