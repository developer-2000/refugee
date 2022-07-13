<?php
namespace App\Http\Requests\Admin\TranslateLocation;

use Illuminate\Foundation\Http\FormRequest;

class AdminTranslateIndexRequest extends FormRequest
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
        $data['language'] = $this->query('language');
        $data['page'] = $this->query('page');
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
            'language' => 'sometimes|nullable|string|min:2|max:2',
            'page' => 'sometimes|nullable|integer',
            'country' => 'sometimes|nullable|string|min:2|max:2',
        ];
    }
}