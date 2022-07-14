<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'alias' => 'required|alpha_dash|max:255',
            'country' => 'required|array',
            'country.*code' => 'string',
            'region' => 'sometimes|nullable|array',
            'region.*code' => 'string',
            'city' => 'sometimes|nullable|array',
            'city.*code' => 'string',
            'youtube_links' => 'sometimes|nullable|array',
            'youtube_links.*' => 'string',
            'rest_address' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'tax_number' => 'sometimes|nullable|string|max:255',
            'founding_date' => 'sometimes|nullable|date|date_format:m/d/Y',
            'facebook_social' => 'sometimes|nullable|active_url',
            'instagram_social' => 'sometimes|nullable|active_url',
            'telegram_social' => 'sometimes|nullable|active_url',
            'twitter_social' => 'sometimes|nullable|active_url',
            'site_company' => 'sometimes|nullable|string|min:1|max:255',
            'count_working' => 'required|integer|in:0,1,2,3',
            'about_company' => 'sometimes|nullable|string',
            'youtube_arr' => 'sometimes|nullable|array',
            'youtube_arr.*' => 'string',
            'image' => 'sometimes|nullable|json',
        ];
    }
}
