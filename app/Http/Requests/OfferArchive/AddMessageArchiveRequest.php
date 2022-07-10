<?php
namespace App\Http\Requests\OfferArchive;

use Illuminate\Foundation\Http\FormRequest;

class AddMessageArchiveRequest extends FormRequest
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
            'offer_id' => 'required|integer|exists:offer_chat_archives,table_id',
            'text' => 'required|string',
        ];
    }
}