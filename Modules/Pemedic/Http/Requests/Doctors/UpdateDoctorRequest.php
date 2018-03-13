<?php

namespace Modules\Pemedic\Http\Requests\Doctors;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateDoctorRequest extends BaseFormRequest
{
    public function rules()
    {
        $doctor = $this->route()->parameter('doctor');
        $userId = $doctor->id;
        return [
            'email' => "required|email|unique:users,email,{$userId}",
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
