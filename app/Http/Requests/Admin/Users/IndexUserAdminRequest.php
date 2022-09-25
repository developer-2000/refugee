<?php
namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserAdminRequest extends FormRequest
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
        $data['user_id'] = $this->query('user_id');
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
            'user_id' => 'sometimes|nullable|integer',
        ];
    }
}
