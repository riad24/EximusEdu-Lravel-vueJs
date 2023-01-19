<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class InstituteResource extends JsonResource
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
            "name"            => $this->name,
            "email"           => $this->email,
            "phone"           => $this->phone,
            "slug"            => $this->slug,
            "status"          => $this->status,
            "description"     => $this->description === null ? '' : $this->description,
        ];
    }

}
