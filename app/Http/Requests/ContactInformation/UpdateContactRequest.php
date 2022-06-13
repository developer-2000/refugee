<?php

namespace App\Http\Requests\ContactInformation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'contact_id' => 'required|integer|exists:user_contacts,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'position' => 'sometimes|nullable|string|max:255',
            'email' => 'required|email|min:5|max:255',
            'skype' => 'sometimes|nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'messengers' => 'sometimes|nullable|array',
            'youtube_arr.*' => 'integer',
            'image' => 'sometimes|nullable|json',
        ];
    }
}
