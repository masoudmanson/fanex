<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        $this->request->set('user_id', Auth::user()->id);

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'firstname' => 'required|between:3,30',
                    'lastname' => 'required|between:3,50',
                    'account_number' => 'required|unique_with:beneficiaries,user_id|between:8,20',
                    'address' => 'sometimes|nullable|string|between:3,256',
                    'tel' => 'required|between:11,15',
                    'fax' => 'nullable|between:11,15',
                    'country' => 'required',
                    'bank_name' => 'required|string|between:3,40',
                    'branch_name' => 'required|string|between:3,60',
                    'branch_address' => 'string|between:3,256',
                    'swift_code' => 'required|bic',
                    'iban_code' => 'required|iban'
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'firstname' => 'required|between:3,30',
                    'lastname' => 'required|between:3,50',
                    'account_number' => 'required|unique_with:beneficiaries,user_id|between:8,20',
                    'address' => 'sometimes|nullable|string|between:3,256',
                    'tel' => 'required|between:11,15',
                    'fax' => 'nullable|between:11,15',
                    'country' => 'required',
                    'bank_name' => 'required|string|between:3,40',
                    'branch_name' => 'required|string|between:3,60',
                    'branch_address' => 'string|between:3,256',
                    'swift_code' => 'required|bic',
                    'iban_code' => 'required|iban'
                ];
            }
            default:
                break;
        }
    }
}
