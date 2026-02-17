<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MensajeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'destinatario_id' => 'required|exists:users,id',
            'asunto' => 'required|string|max:255',
            'contenido' => 'required|string|max:5000'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'destinatario_id.required' => 'Debes seleccionar un destinatario',
            'destinatario_id.exists' => 'El destinatario seleccionado no existe',
            'asunto.required' => 'El asunto es obligatorio',
            'asunto.max' => 'El asunto no puede exceder 255 caracteres',
            'contenido.required' => 'El mensaje no puede estar vacío',
            'contenido.max' => 'El mensaje no puede exceder 5000 caracteres'
        ];
    }
}
