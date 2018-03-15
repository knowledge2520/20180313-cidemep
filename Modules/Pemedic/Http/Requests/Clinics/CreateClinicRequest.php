<?php

namespace Modules\Pemedic\Http\Requests\Clinics;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateClinicRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:users,email',
            'clinic_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'vip_phone' => 'required|max:255',
            'address' => 'max:255',
            'map' => 'max:255',
            'word_time' => 'max:255',
            'website' => 'max:255',
            'issurance' => 'max:255',
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
