<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ActivateAccountRequest extends FormRequest
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
        $data['id'] = $this->query('id');
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
            'id' => 'required|integer|exists:users,id',
            'code' => 'required|string|min:10|max:20|exists:codes,code',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Data not valid',
            'id.integer' => 'Data not valid',
            'id.exists' => 'Data not valid',
            'code.required' => 'Data not valid',
            'code.string' => 'Data not valid',
            'code.min' => 'Data not valid',
            'code.max' => 'Data not valid',
            'code.exists' => 'Account already activated',
        ];
    }
}
