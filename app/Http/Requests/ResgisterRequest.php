<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResgisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'apellidos' => 'nullable|string|max:255',
            'telefono' => 'required|string|min:9|max:20|regex:/^[0-9+\s\-\(\)]+$/',
            'direccion' => 'required|string|min:5|max:500',
            'ciudad' => 'required|string|min:2|max:100',
            'codigo_postal' => 'required|string|min:4|max:10|regex:/^[0-9]{4,10}$/',
            'fecha_nacimiento' => 'nullable|date'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.min' => 'El teléfono debe tener al menos 9 caracteres',
            'telefono.regex' => 'El formato del teléfono no es válido',
            'direccion.required' => 'La dirección es obligatoria',
            'direccion.min' => 'La dirección debe tener al menos 5 caracteres',
            'ciudad.required' => 'La ciudad es obligatoria',
            'ciudad.min' => 'La ciudad debe tener al menos 2 caracteres',
            'codigo_postal.required' => 'El código postal es obligatorio',
            'codigo_postal.min' => 'El código postal debe tener al menos 4 dígitos',
            'codigo_postal.regex' => 'El código postal solo debe contener números'
        ];
    }
}
