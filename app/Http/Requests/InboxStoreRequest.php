<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class InboxStoreRequest extends FormRequest
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
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required'
        ];
    }

    // in case you want to return single line of error instead of array of errors..
    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}
