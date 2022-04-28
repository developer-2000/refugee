<?php
namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class ShowVacancyRequest extends FormRequest
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
        $data['vacancy_id'] = $this->route('vacancy.id');
        $data['country'] = $this->query('country');
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
            'vacancy_id' => 'required|integer|exists:vacancies,id',
            'country' => 'sometimes|string|max:2',
        ];
    }
}
