<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PedidoRequest extends FormRequest
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
            'metodo_pago' => 'nullable|string|max:50',
            'direccion_envio' => 'nullable|string|max:500',
            'notas' => 'nullable|string|max:1000'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'metodo_pago.max' => 'El método de pago no puede exceder 50 caracteres',
            'direccion_envio.max' => 'La dirección de envío no puede exceder 500 caracteres',
            'notas.max' => 'Las notas no pueden exceder 1000 caracteres'
        ];
    }
}
