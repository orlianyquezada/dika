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
            'date_mo' => 'required|date',
            'item_mo' => 'required|regex:/^[a-z ]+$/i|min:10|max:255',
            'quanty_mo' => 'required|numeric|min:1',
            'qty_mo' => 'required|numeric|min:1',
            'ubication_mo' => 'required|regex:/^[a-z ]+$/i|min:10|max:255',
            'observation_mo' => 'required|regex:/^[a-z ]+$/i|min:10|max:255',
            'customer_id' => 'required|numeric',
            'condition_id' => 'required|numeric',
            'status_id' => 'required|numeric',
            'shipment_id' => 'numeric|nullable',
            'employee_id' => 'numeric|nullable',
            'movement_id' => 'numeric|nullable',
            'user_id' => 'required|numeric'
        ];
    }
}
