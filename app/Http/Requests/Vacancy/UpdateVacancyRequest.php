<?php

namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacancyRequest extends FormRequest
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
        $data = parent::all($keys);
        $data['id'] = $this->route('vacancy');
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
            'id' => 'required|integer|exists:vacancies,id',
            'position' => 'required|string|max:255',
            'categories' => 'sometimes|array',
            'categories.*' => 'integer',
            'country' => 'required|array',
            'country.*code' => 'string',
            'region' => 'sometimes|nullable|array',
            'region.*code' => 'string',
            'city' => 'sometimes|nullable|array',
            'city.*code' => 'string',
            'rest_address' => 'required|string|max:255',
            'vacancy_suitable' => 'sometimes|array',
            'vacancy_suitable.*' => 'integer',
            'commentary_age' => 'sometimes|nullable|string|max:255',
            'type_employment' => 'required|integer|in:0,1,2,3',
            'salary_but' => 'required|string|max:15',
            'salary_from' => 'sometimes|nullable|integer',
            'salary_to' => 'sometimes|nullable|integer',
            'salary_sum' => 'sometimes|nullable|integer',
            'salary_comment' => 'sometimes|nullable|string|max:255',
            'experience' => 'required|integer|in:0,1,2,3',
            'education' => 'required|integer|in:0,1,2,3,4',
            'checkbox_city' => 'required|boolean',
            'search_city' => 'sometimes|nullable|integer',
            'text_requirements' => 'sometimes|nullable|string',
            'text_working' => 'sometimes|nullable|string',
            'text_responsibilities' => 'sometimes|nullable|string',
            'contacts' => 'sometimes|array',
            'contacts.*' => 'integer',
            'how_respond' => 'required|integer|in:0,1',
            'job_posting' => 'required|integer|in:0,1',
        ];
    }
}
