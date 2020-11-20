<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class IPBlockerUpdateRequest extends FormRequest
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
        $id = decrypt(request('id'));

        return [
            'ip_address' => 'required|unique:ipblockers,ip_address,' . $id
        ];
    }

    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}
