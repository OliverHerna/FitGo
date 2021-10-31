<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'first_name' => 'present|string|max:254',
            'last_name' => 'present|string|max:254',
            'email' => [
                'present',
                'email',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'phone' => 'present|string|max:254',
            'role' => 'present',
            'client_code_group' => 'required|array|min:1',
            'company_name' => 'required_if:role,==,3|string|max:254',
            'password' => 'nullable|confirmed|alpha_dash|min:8',
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
            'client_code_group' => 'sector de clientes',
            'password' => 'contraseña',
            'company_name' => 'nombre de la compañia'
        ];
    }
}
