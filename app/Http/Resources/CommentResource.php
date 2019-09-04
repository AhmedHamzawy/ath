<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'text' => $this->text,
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
