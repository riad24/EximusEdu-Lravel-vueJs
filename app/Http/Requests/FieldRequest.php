<?php

namespace App\Http\Requests;

use App\Models\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FieldRequest extends FormRequest
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
            'title'           => ['required', 'string', 'max:190'],
            'type'            => ['required', 'string'],
            'field_type'      => ['required', 'string'],
            'institute_id'    => ['required', 'numeric'],
            'status'          => ['required', 'numeric', 'max:24'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->fieldTitleUniqueCheck()) {
                $validator->errors()->add('title', 'The title already exists.');
            }
        });
    }

    private function fieldTitleUniqueCheck()
    {
        $institute_id = request('institute_id') ?? 0;
        $id            = $this->route('fields.id');

        $queryArray['title']          = request('title');
        $queryArray['institute_id']   = $institute_id;

        $fields = Field::where($queryArray)->where('id', '!=', $id)->first();

        if (blank($fields)) {
            return false;
        }
        return true;
    }

}
