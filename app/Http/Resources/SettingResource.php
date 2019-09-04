<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'about_ar' => $this->about_ar,
            'about_en' => $this->about_en,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'google_plus' => $this->google_plus,
            'phone' => $this->phone,
            'months' => $this->months,
            'order_no' => $this->order_no,
        ];
    
    }
}
