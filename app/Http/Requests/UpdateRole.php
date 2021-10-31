<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRole extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:254',
                Rule::unique('roles')->ignore($this->route('role')),
            ],
            'User' => 'array',
            'Role' => 'array',
            'Configuration' => 'array',
            'Order' => 'array',
            'OrderDetail' => 'array',
            'Weight' => 'array',
            'PurchaseOrder' => 'array',
            'ReportsPurchase' => 'array',
            'ReportsSales' => 'array',
            'ReportsWarehouse' => 'array',
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
            'name' => 'nombre',
            'User' => 'usuarios',
            'Role' => 'roles',
            'Configuration' => 'configuración',
            'Order' => 'hojas de pedido',
            'OrderDetail' => 'detalles de hoja de pedido',
            'Weight' => 'pesaje',
            'PurchaseOrder' => 'orden de compra',
            'ReportsPurchase' => 'reportes de compra',
            'ReportsSales' => 'reportes de venta',
            'ReportsWarehouse' => 'reportes de almacén',
        ];
    }
}
