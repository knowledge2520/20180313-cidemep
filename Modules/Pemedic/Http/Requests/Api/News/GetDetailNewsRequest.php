<?php

namespace Modules\Pemedic\Http\Requests\Api\News;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pemedic\Http\Requests\Api\ApiRequest;

class GetDetailNewsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
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
