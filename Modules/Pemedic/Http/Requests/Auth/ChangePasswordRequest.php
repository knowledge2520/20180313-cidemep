<?php

namespace Modules\Pemedic\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pemedic\Http\Requests\Api\ApiRequest;

class ChangePasswordRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currentPassword' => 'required',
            'newPassword' => 'required',
            
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }
}
