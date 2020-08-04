<?php

namespace App\Http\Requests;

use App\Models\Domain;
use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BlogWriterStoreRequest extends FormRequest
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
        $tenant_id = Domain::getTenantId();

        return [
            'image'  => 'mimes:jpeg,jpg,png,gif|max:10000', // max 10MB
            'slug'   => 'required|unique:destinations,slug,NULL,id,tenant_id,' . $tenant_id
        ];
    }

    // in case you want to return single line of error instead of array of errors..
    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}
