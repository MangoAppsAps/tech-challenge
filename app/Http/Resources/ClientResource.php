<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $client = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
            'journals' => JournalResource::collection($this->whenLoaded('journals')),
        ];

        if ($this->bookings_count) $client['bookings_count'] = $this->bookings_count;

        return $client;
    }
}
