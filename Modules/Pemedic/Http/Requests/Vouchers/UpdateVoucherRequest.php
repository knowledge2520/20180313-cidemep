<?php

namespace Modules\Pemedic\Http\Requests\Vouchers;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateVoucherRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'clinic_id'     => 'required',
            'name'          => 'required|max:255',
            'start_date'    => 'required',
            'expiry_date'   => 'required',
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
