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
        $data['country'] = $this->route('country');
        $data['city'] = $this->route('city');
        $data['position'] = $this->query('position');
        $data['categories'] = $this->query('categories');
        $data['languages'] = $this->query('languages');
        $data['suitable'] = $this->query('suitable');
        $data['employment'] = $this->query('employment');
        $data['salary'] = $this->query('salary');
        $data['experience'] = $this->query('experience');
        $data['education'] = $this->query('education');
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
            'country' => 'sometimes|nullable|string|min:2|max:50',
            'city' => 'sometimes|nullable|string|min:2|max:50',
            'categories' => 'sometimes|nullable|string|max:200',
            'languages' => 'sometimes|nullable|string|max:20',
            'suitable' => 'sometimes|nullable|string|max:20',
            'employment' => 'sometimes|nullable|integer|in:0,1,2,3',
            'salary' => 'sometimes|nullable|string|max:50',
            'experience' => 'sometimes|nullable|integer|in:0,1,2,3',
            'education' => 'sometimes|nullable|integer|in:0,1,2,3,4',
        ];
    }
}
