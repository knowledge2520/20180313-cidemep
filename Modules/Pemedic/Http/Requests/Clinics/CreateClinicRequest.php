<?php

namespace Modules\Pemedic\Http\Requests\Clinics;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateClinicRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'clinic_name' => 'required',
            'phone' => 'required',
            'vip_phone' => 'required',
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
