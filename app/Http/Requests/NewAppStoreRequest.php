<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class MemberStoreRequest extends FormRequest
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
            'name_of_institution' => 'required',
            'address'             => 'required',
            'state'               => 'required',
            'type'                => 'required',
            'establishment_date'  => 'required',
            'commerical_register_no' => 'required'
            'telephone_no'        => 'required',
            'email_address'       => 'required|email',
            'website_url'         => 'required',
            'name'                => 'required',
            'date'                => 'required',
        ];
    }

    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}
