<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
        $status = 1;
        return [
            'name'       => 'required|string',
            'email'      => 'required|email|unique:users,email,NULL,id,status,' . $status,
            'password'   => 'required',
        ];
    }

    // in case you want to return single line of error instead of array of errors..
    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}