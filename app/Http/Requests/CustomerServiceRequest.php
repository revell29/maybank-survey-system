<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerServiceRequest extends FormRequest
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
            'nik' => 'required|unique:customer_services,nik',
            'name' => 'required',
            'branch_id' => 'required',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nik.unique' => 'The NIK has already been taken.'
        ];
    }
}
