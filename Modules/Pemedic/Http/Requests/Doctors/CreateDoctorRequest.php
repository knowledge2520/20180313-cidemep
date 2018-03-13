<?php

namespace Modules\Pemedic\Http\Requests\Doctors;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateDoctorRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
