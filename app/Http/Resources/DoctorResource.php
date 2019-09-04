<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'certificate' => $this->certificate,
            'dateofbirth' => $this->dateofbirth,
            'cost' => $this->cost,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'rating' => $this->rating,
            'image' => $this->image,
            'status_id' => $this->status_id,
            'service' => new ServiceResource($this->whenLoaded('service')),
            'status' => new StatusResource($this->whenLoaded('status')),
        ];
    }
}
