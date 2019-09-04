<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class InvoiceResource extends JsonResource
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
        $created_at = $created_at->toDateString();
        return [
            'id' => $this->id,
            'hospital' => new UserResource($this->whenLoaded('hospital')),
            'url' => $this->url,
            'created_at' => $created_at
        ];
    }
}
