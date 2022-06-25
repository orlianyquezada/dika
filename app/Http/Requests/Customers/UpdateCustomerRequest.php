<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name_cu' => 'required|min:10|max:120|regex:/^[a-z ]+$/i',
            'phone_cu' => 'required|numeric|min:10',
            'email_cu' => 'required|min:20|email:rfc,dns'
        ];
    }

    public function messages(){
        return [
            'name_cu.required' => 'Customer name is required.',
            'name_cu.min' => 'The minimum number of letters must be 10',
            'name_cu.max' => 'The maximum number of letters must be 120',
            'name_cu.regex' => 'The name field only accepts letters',
            'phone_cu.required' => 'Customer phone is required',
            'phone_cu.min' => 'The minimun of phone numbers must be 10',
            'phone_cu.numeric' => 'The phone field only accepts numbers',
            'email_cu.required' => 'Customer email is required',
            'email_cu.min' => 'The minimum number of letters must be 20',
            'email_cu.email' => 'The email entered is not valid'
        ];
    }
}
