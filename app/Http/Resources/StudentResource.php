<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            "class_name"      => $this->class_name,
            "institute_name"  => optional($this->institute)->name,
            "institute_id"    => $this->institute_id,
            "name"            => $this->name,
            "email"           => $this->email,
            "phone"           => $this->phone,
            "status"          => $this->status,
        ];
    }

}
