<?php
namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class IndexVacancyRequest extends FormRequest
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
        $data['position'] = $this->query('position');
        $data['country'] = $this->query('country');
        $data['region'] = $this->query('region');
        $data['city'] = $this->query('city');
        $data['categories'] = $this->query('categories');
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
            'position' => 'sometimes|nullable|string|max:100',
            'country' => 'sometimes|nullable|string|max:2',
            'region' => 'sometimes|nullable|string|max:8',
            'city' => 'sometimes|nullable|string|max:8',
            'categories' => 'sometimes|nullable|string|max:200',
        ];
    }
}
