<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            "id"              => $this->id,
            "slug"            => $this->class_name,
            "institute_name"  => optional($this->institute)->name,
            "institute_id"    => $this->institute_id,
            "title"           => $this->title,
            "type"            => $this->type,
            "field_type"      => $this->field_type,
            "status"          => $this->status,
        ];
    }

}
