<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            'name'    => [
                'required',
                'string',
                'max:190',
                Rule::unique("students", "name")->ignore($this->route('student.id'))
            ],
            'class_name'=> ['required', 'string', 'max:190',],
            'email'  => [
                'required',
                'email',
                'max:190',
                Rule::unique("students", "email")->ignore($this->route('student.id'))
            ],

            'institute_id'    => ['required', 'numeric'],
            'phone'           => ['required', 'string', 'max:20'],
            'status'          => ['required', 'numeric', 'max:24'],
        ];
    }

}
