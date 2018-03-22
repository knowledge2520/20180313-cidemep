<?php

namespace Modules\Pemedic\Http\Requests\Medicals;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateMedicalRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'clinic_id' => 'required',
            'patient_id' => 'required',
            // 'date' => 'required',
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
