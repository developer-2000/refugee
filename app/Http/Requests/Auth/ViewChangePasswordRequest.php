<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ViewChangePasswordRequest extends FormRequest
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

    public function all($keys = null) {
        $data['code'] = $this->query('code');
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|min:10|max:20|exists:codes,code',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Data not valid',
            'code.string' => 'Data not valid',
            'code.min' => 'Data not valid',
            'code.max' => 'Data not valid',
            'code.exists' => 'This link has already been used',
        ];
    }
}
