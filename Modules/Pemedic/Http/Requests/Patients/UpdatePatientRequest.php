<?php

namespace Modules\Pemedic\Http\Requests\Patients;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePatientRequest extends BaseFormRequest
{
    public function rules()
    {
        $patient = $this->route()->parameter('patient');
        $userId = $patient->id;
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
