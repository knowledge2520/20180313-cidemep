<?php

namespace Modules\Pemedic\Http\Requests\Doctors;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateDoctorRequest extends BaseFormRequest
{
    public function rules()
    {
        $doctor = $this->route()->parameter('doctor');
        $userId = $doctor->id;
        $userProfile_id = $doctor->profile->id;
        return [
            'email' => "required|email|max:255|unique:users,email,{$userId}",
            'phone' => "required|numeric|unique:pemedic__user_profiles,phone,{$userProfile_id}",
            'full_name' => 'max:255',
            'address' => 'max:255',
            'image' => 'mimes:jpeg,jpg,png',
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
