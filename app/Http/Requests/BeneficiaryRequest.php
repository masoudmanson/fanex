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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'firstname' => 'required|between:3,30',
                    'lastname' => 'required|between:3,50',
                    'account_number' => 'required|unique:beneficiaries|between:8,20',
                    'address' => 'sometimes|nullable|string|between:3,256',
                    'tel' => 'required|between:11,15',
                    'fax' => 'nullable|between:11,15',
                    'country' => 'required',
                    'bank_name' => 'required|string|between:3,40',
                    'branch_name' => 'required|string|between:3,60',
                    'branch_address' => 'string|between:3,256',
                    'swift_code' => 'required|between:8,11',
                    'iban_code' => 'required|string|between:10,34'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'firstname' => 'required|between:3,30',
                    'lastname' => 'required|between:3,50',
                    'account_number' => 'required|between:8,20',
                    'address' => 'sometimes|nullable|string|between:3,256',
                    'tel' => 'required|between:11,15',
                    'fax' => 'nullable|between:11,15',
                    'country' => 'required',
                    'bank_name' => 'required|string|between:3,40',
                    'branch_name' => 'required|string|between:3,60',
                    'branch_address' => 'string|between:3,256',
                    'swift_code' => 'required|between:8,11',
                    'iban_code' => 'required|string|between:10,34'
                ];
            }
            default:
                break;
        }
    }
}
