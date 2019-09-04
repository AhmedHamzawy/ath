<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'client_id' => $this->client_id,
            'hospital_id' => $this->hospital_id,
            'doctor_id' => $this->doctor_id,
            'state_id' => $this->state_id,
            'name' => $this->name,
            'date_time' => $this->date_time,
            'lat' => $this->lat,
            'lon' => $this->lon, 
            'phone' => $this->phone,
            'cost' => $this->cost,
            'other' => $this->other,
            'client' => new UserResource($this->whenLoaded('client')),
            'hospital' => new HospitalResource($this->whenLoaded('hospital')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'state' => new StateResource($this->whenLoaded('state')),
        ];
    }
}
