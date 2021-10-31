<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:254',
            'last_name' => 'required|string|max:254',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:254',
            'role' => 'required|exists:roles,id',
            'paquete' => '',
            'company_name' => 'required_if:role,==,3|string|max:254',
            'password' => 'required_unless:role,3|confirmed|alpha_dash|min:8',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => 'nombre(s)',
            'last_name' => 'apellido paterno',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'role' => 'rol',
            'company_name' => 'nombre de la compañia',
            'password' => 'contraseña',
        ];
    }
}
