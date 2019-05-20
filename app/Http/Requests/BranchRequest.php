<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'branch_id' => 'required|unique:branches,branch_id',
            'branch_name' => 'required|unique:branches,branch_name',
            'branch_address' => 'required',
        ];
    }

    public function message()
    {
        return [
            'branch_id.unique' => 'Branch code already exist'
        ];
    }
}
