<?php
namespace App\Http\Requests\Admin\Vacancies;

use Illuminate\Foundation\Http\FormRequest;

class VerifiedByAdminRequest extends FormRequest
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
            'vacancy_id' => 'required|integer|exists:vacancies,id',
            'verified' => 'required|integer|in:0,1',
        ];
    }
}
