<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryRequest extends FormRequest
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
        'firstname'=>'required|between:3,30',
        'lastname'=>'required|between:3,50',
        'account_number'=>'required|digits|between:8,20',
        'address'=>'required',
        'tel'=>'required|digits|between:11,15',
        'fax'=>'required|digits|between:11,15',
        'bank_name'=>'required|string|between:3,40',
        'branch_name'=>'required|string|between:3,60',
        'branch_address'=>'required|string|between:3,256',
        'swift_code'=>'required|digits|between:8,11',
        'iban_code'=>'required|string|between:10,34',
            ];
    }
}
