<?php

namespace Modules\Pemedic\Http\Requests\Patients;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePatientRequest extends BaseFormRequest
{
    public function rules()
    {
        $patient = $this->route()->parameter('patient');
        $userId = $patient->id;
        $userProfile_id = $patient->profile->id;
        return [
            'email' => "required|email|max:255|unique:users,email,{$userId}",
            'phone' => "required|numeric|unique:pemedic__user_profiles,phone,{$userProfile_id}",
            'height' => 'numeric',
            'weight' => 'numeric',
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
