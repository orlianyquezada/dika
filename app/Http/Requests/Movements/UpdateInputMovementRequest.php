<?php

namespace App\Http\Requests\Movements;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInputMovementRequest extends FormRequest
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
            'datetime_inm' => 'required|date', 
            'item_inm' => 'required', 
            'quanty_inm' => 'required|numeric', 
            'qty_boxes_inm' => 'required|numeric', 
            'ubication_inm' => 'required', 
            'observation_inm' => 'nullable', 
            'customer_id' => 'required|numeric', 
            'condition_id' => 'required|numeric', 
            'status_id' => 'required|numeric', 
            'user_id' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'datetime_inm.required' => 'Date of entry of the movement is required',
            'datetime_inm.date' => 'The date field must be date-formatted',
            'item_inm.required' => 'The item is required',
            'quanty_inm.required' => 'The quanty of items is required',
            'quanty_inm.numeric' => 'The quanty field only accepts numbers',
            'qty_boxes_inm.required' => 'The quanty boxes of items is required',
            'qty_boxes_inm.numeric' => 'The quanty field only accepts numbers',
            'ubication_inm.required' => 'Item location is required',
            'customer_id.required' => 'The customer is required',
            'customer_id.numeric' => 'The customer field only accepts they id',
            'condition_id.required' => 'The condition is required',
            'condition_id.numeric' => 'The condition field only accepts they id',
            'status_id.required' => 'The status is required',
            'status_id.numeric' => 'The status field only accepts they id',
            'user_id.required' => 'The user is required',
            'user_id.numeric' => 'The user field only accepts they id'
        ];
    }
}
