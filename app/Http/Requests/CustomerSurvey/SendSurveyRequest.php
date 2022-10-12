<?php

namespace App\Http\Requests\CustomerSurvey;

use Illuminate\Foundation\Http\FormRequest;

class SendSurveyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|min:5|max:255',
            'comment' => 'sometimes|nullable|string',
            'arr_data' => 'sometimes|array',
        ];
    }
}
