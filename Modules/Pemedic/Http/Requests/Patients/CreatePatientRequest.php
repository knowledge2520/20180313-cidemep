<?php

namespace Modules\Pemedic\Http\Requests\Patients;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePatientRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255|numeric',
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
