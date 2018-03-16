<?php

namespace Modules\Pemedic\Http\Requests\Insurance;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateInsuranceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
             'name' => 'required|max:255',
             'phone' => 'required|numeric',
             'address' => 'required|max:255',
             'work_time' => 'required|max:255',
             'website' => 'required|max:255',
             'ordering' => 'required|numeric',
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
