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
        $data['prefix_c'] = $this->route('prefix_c');
        $data['prefix_r_c'] = $this->route('prefix_r_c');
        $data['alias'] = $this->route('alias');
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
            'prefix_c' => 'required|string|min:2|max:50',
            'prefix_r_c' => 'required|string|min:2|max:50',
            'alias' => 'required|string|exists:vacancies,alias',
        ];
    }
}
