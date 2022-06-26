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
            'name_cu' => 'required|regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/',
            'phone_cu' => 'required|numeric',
            'email_cu' => 'required|email:rfc,dns'
        ];
    }

    public function messages(){
        return [
            'name_cu.required' => 'Customer name is required.',
            'name_cu.regex' => 'The name field only accepts letters',
            'phone_cu.required' => 'Customer phone is required',
            'phone_cu.numeric' => 'The phone field only accepts numbers',
            'email_cu.required' => 'Customer email is required',
            'email_cu.email' => 'The email entered is not valid'
        ];
    }
}
