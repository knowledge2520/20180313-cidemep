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
            'email' => "required|email|max:255|unique:users,email,{$userId}",
            'phone' => 'required|max:255',
            'full_name' => 'max:255',
            'address' => 'max:255',
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
