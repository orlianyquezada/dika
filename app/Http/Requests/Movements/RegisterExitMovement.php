<?php

namespace App\Http\Requests\Movements;

use Illuminate\Foundation\Http\FormRequest;

class RegisterExitMovement extends FormRequest
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
            'datetime_exm' => 'required|date', 
            'address_exm' => 'required', 
            'observation_exm' => 'nullable', 
            'input_movement_id' => 'required|numeric', 
            'customer_id' => 'required|numeric', 
            'condition_id' => 'required|numeric', 
            'status_id' => 'required|numeric', 
            'shipment_id' => 'required|numeric', 
            'employee_id' => 'required|numeric', 
            'user_id' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'datetime_exm.required' => 'Date of close of the movement is required',
            'datetime_inm.date' => 'The date field must be date-formatted',
            'address.required' => 'The address is required',
            'input_movement_id.required' => 'The id of the input movement is required',
            'input_movement_id.numeric' => 'The id of the input movement field only accepts they id',
            'customer_id.required' => 'The customer is required',
            'customer_id.numeric' => 'The customer field only accepts they id',
            'condition_id.required' => 'The condition is required',
            'condition_id.numeric' => 'The condition field only accepts they id',
            'status_id.required' => 'The status is required',
            'status_id.numeric' => 'The status field only accepts they id',
            'shipment_id.required' => 'The shipment is required',
            'shipment_id.numeric' => 'The shipment field only accepts they id',
            'employee_id.required' => 'The employee is required',
            'employee_id.numeric' => 'The employee field only accepts they id',
            'user_id.required' => 'The user is required',
            'user_id.numeric' => 'The user field only accepts they id'
        ];
    }
}
