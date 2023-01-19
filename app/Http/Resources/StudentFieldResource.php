<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            "id"                => $this->id,
            "field_name"        => $this->field_name,
            "field_value"       => $this->field_value,
            "field_id"          => $this->field_id,
            "student_id"        => $this->student_id ,
            "institute_id"      => $this->institute_id,
        ];
    }

}
