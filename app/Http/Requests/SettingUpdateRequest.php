<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
        $id = $this->route()->parameter('setting')->id;

        return [
            'id' => 'required|unique:settings,id,' . $id,
            // 'title' => 'required',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000, // max 10MB
        ];
    }

    protected function formatErrors (Validator $validator)
    {
        return ['message' => $validator->errors()->first()];
    }
}
