<?php

namespace App\Http\Requests\Movements;

use Illuminate\Foundation\Http\FormRequest;

class RegisterMovementRequest extends FormRequest
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
            'date_mo' => 'required|datetime',
            'item_mo' => 'required|text',
            'quanty_mo' => 'required|numeric',
            'qty_mo' => 'required|numeric',
            'ubication_mo' => 'required',
            'observation_mo' => 'required',
            'customer_id' => 'required',
            'condition_id' => 'required',
            'status_id' => 'required',
            'shipment_id' => '',
            'employee_id' => '',
            'movement_id' => '',
            'user_id' => 'required'
        ];
    }
}
