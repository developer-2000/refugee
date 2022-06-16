<?php
namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;

class ShowResumeRequest extends FormRequest
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
        $data['resume_id'] = $this->route('resume.id');
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
            'resume_id' => 'required|integer|exists:user_resumes,id',
        ];
    }
}
