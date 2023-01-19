<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstituteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name'            => [
                'required',
                'string',
                'max:190',
                Rule::unique("institutes", "name")->ignore($this->route('institute.id'))
            ],
            'email'                 => [
                'required',
                'email',
                'max:190',
                Rule::unique("users", "email")->ignore($this->route('institute.id'))
            ],

            'phone'           => ['required', 'string', 'max:20'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'status'          => ['required', 'numeric', 'max:24'],
        ];
    }

}
