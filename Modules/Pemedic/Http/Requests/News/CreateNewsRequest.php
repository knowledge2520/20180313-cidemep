<?php

namespace Modules\Pemedic\Http\Requests\News;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateNewsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'vi.title' => 'required|max:255',
            'vi.content' => 'required',
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
        return [
             'vi.title.required' => 'The title field is required',
             'vi.content.required' => 'The body field is required',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
