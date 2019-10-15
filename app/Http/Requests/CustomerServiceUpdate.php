<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerServiceUpdate extends FormRequest
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

    public function rules()
    {
        return [
            'nik' => 'required',
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
