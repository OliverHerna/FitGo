<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaquete extends FormRequest
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
            'name' => 'required|string|max:254',
            'total_hours' => 'required|numeric|max:254',
            'benefit' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'total_hours' => 'horas totales',
            'benefit' => 'beneficio',
        ];
    }
}
