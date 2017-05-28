<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemittanceForm extends FormRequest
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
            'captcha' => 'required|captcha'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() //todo: maybe it should be delete, and add to lang validation file (for ability to define other language error msgs)
    {
//        return [
//            'captcha.required' => 'captcha required.',
//            'captcha.captcha'  => "Incorrect captcha.",
//            'amount.required'  => "please inter an amount.",
//        ];
    }
}
