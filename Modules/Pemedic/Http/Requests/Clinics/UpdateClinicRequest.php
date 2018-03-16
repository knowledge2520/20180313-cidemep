<?php

namespace Modules\Pemedic\Http\Requests\Clinics;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateClinicRequest extends BaseFormRequest
{
    public function rules()
    {
        $clinicProfile = $this->route()->parameter('clinic');
        $userId = $clinicProfile->user_id;
        return [
            'email' => "required|email|max:255|unique:users,email,{$userId}",
            'clinic_name' => 'required|max:255',
            'phone' => 'required|max:255|numeric',
            'vip_phone' => 'required|max:255|numeric',
            'address' => 'max:255',
            'map' => 'max:255',
            'word_time' => 'max:255',
            'website' => 'max:255',
            'issurance' => 'max:255',
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
