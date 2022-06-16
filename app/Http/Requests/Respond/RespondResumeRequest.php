<?php

namespace App\Http\Requests\Respond;

use Illuminate\Foundation\Http\FormRequest;

class RespondResumeRequest extends FormRequest
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
            'resume_id' => 'required|integer|exists:user_resumes,id',
            'bool_tab' => 'required|integer|in:0,1',
            'vacancy_id' => 'sometimes|nullable|integer|exists:vacancies,id',
            'textarea_letter' => 'sometimes|nullable|string',
            'old_file_id' => 'sometimes|nullable|integer|exists:user_resumes,id',
            'new_file' => 'sometimes|nullable|file|mimes:pdf,docx,doc,txt|max:2058',
        ];
    }
}
