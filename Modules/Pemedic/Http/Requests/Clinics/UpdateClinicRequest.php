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
            'email' => "required|email|unique:users,email,{$userId}",
            'clinic_name' => 'required',
            'phone' => 'required',
            'vip_phone' => 'required',
            'address' => 'required',
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
