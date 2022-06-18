<?php

namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumeRequest extends FormRequest
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
            'position' => 'required|string|max:255',
            'country' => 'required|array',
            'country.*code' => 'string',
            'region' => 'sometimes|nullable|array',
            'region.*code' => 'string',
            'city' => 'sometimes|nullable|array',
            'city.*code' => 'string',
            'data_birth' => 'sometimes|nullable|date|date_format:m/d/Y',
            'categories' => 'sometimes|array',
            'categories.*' => 'integer',
            'salary_but' => 'required|string|max:15',
            'from' => 'sometimes|nullable|integer',
            'to' => 'sometimes|nullable|integer',
            'salary_sum' => 'sometimes|nullable|integer',
            'salary_comment' => 'sometimes|nullable|string|max:255',
            'type_employment' => 'required|integer|in:0,1,2,3',
            'languages' => 'sometimes|array',
            'languages.*' => 'integer',
            'education' => 'required|integer|in:0,1,2,3,4',
            'job_posting' => 'required|integer|in:0,1',
            'experience' => 'required|integer|in:0,1,2,3',
            'text_experience' => 'sometimes|nullable|string',
            'text_wait' => 'sometimes|nullable|string',
            'text_achievements' => 'sometimes|nullable|string',
        ];
    }
}
