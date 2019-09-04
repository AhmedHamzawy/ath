<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class HospitalResource extends JsonResource
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
         $created_at = new Carbon($this->created_at);
         $created_at = $created_at->toDateTimeString();
         $updated_at = new Carbon($this->updated_at);
         $updated_at = $updated_at->toDateTimeString();
        return [
            
                'id' => $this->id,
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'lat' => $this->lat,
                'lon' => $this->lon,
                'address' => $this->address,
                'description_ar' => $this->description_ar,
                'description_en' => $this->description_en,
                'type' => $this->type,
                'image' => $this->image,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            
        ];
    }
}
