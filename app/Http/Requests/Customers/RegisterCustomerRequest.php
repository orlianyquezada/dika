<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest
{
    protected $redirect = 'customers';
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
            'name_cu' => 'required|min:10|max:120|regex:/^[a-z ]+$/i',
            'phone_cu' => 'required|unique:customers,phone_cu|numeric|min:10'
        ];
    }

    public function messages(){
        return [
            'name_cu.required' => 'Customer name is required.',
            'name_cu.min' => 'The minimum number of letters must be 10',
            'name_cu.max' => 'The maximum number of letters must be 120',
            'name_cu.regex' => 'The name field only accepts letters',
            'phone_cu.required' => 'Customer phone is required',
            'phone_cu.unique' => 'Another customer has that phone number.',
            'phone_cu.min' => 'The minimun of phone numbers must be 10',
            'phone_cu.numeric' => 'The phone field only accepts numbers'
        ];
    }
}
