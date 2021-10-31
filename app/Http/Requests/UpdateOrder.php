<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrder extends FormRequest
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
            'hours' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $d = self::findMod($value, 0.25);
                    if ($d != 0) {
                        $fail('horas debe ser divisible entre 0.25'); // your message
                    }
                },
            ],
            'folio' => 'required|string|max:254',
        ];
    }

    public function attributes()
    {
        return [
            'hours' => 'horas',
            'folio' => 'folio',
        ];
    }
    function findMod($a, $b)
    {

        // Handling negative values
        if ($a < 0)
            $a = -$a;
        if ($b < 0)
            $b = -$b;

        // Finding mod by repeated
        // subtraction
        $mod = $a;
        while ($mod >= $b)
            $mod = $mod - $b;

        // Sign of result typically
        // depends on sign of a.
        if ($a < 0)
            return -$mod;

        return $mod;
    }
}
