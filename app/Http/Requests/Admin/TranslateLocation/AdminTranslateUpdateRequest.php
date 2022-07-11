<?php
namespace App\Http\Requests\Admin\TranslateLocation;

use Illuminate\Foundation\Http\FormRequest;

class AdminTranslateUpdateRequest extends FormRequest
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
            'translate_lang' => 'required|string|min:2|max:2',
            'value' => 'required|string',
            'country' => 'required|string|min:2|max:2',
            'row' => 'required|string|in:property,translate',
            'old_property' => 'sometimes|nullable|string',
            'old_value' => 'sometimes|nullable|string',
        ];
    }
}
