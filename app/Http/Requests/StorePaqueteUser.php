<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaqueteUser extends FormRequest
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
            'client' => 'required|exists:users,id',
            'package' => 'required|exists:paquetes,id',
        ];
    }
    public function attributes()
    {
        return [
            'client' => 'cliente',
            'package' => 'paquete',
        ];
    }
}