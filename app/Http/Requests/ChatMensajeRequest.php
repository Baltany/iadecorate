<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChatMensajeRequest extends FormRequest
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
            'contenido' => 'required|string|max:2000',
            'chat_id' => 'nullable|exists:chats,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'contenido.required' => 'El mensaje no puede estar vacío',
            'contenido.max' => 'El mensaje no puede exceder 2000 caracteres',
            'chat_id.exists' => 'El chat seleccionado no existe'
        ];
    }
}
