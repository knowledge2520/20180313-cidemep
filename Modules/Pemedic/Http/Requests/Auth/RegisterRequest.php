<?php

namespace Modules\Pemedic\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pemedic\Http\Requests\Api\ApiRequest;

class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'full_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            
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
