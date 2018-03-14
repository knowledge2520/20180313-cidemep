<?php

namespace Modules\Pemedic\Http\Requests\Api\Message;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pemedic\Http\Requests\Api\ApiRequest;

class CreateMessageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required',
            'doctor_id' => 'required|numeric',
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
