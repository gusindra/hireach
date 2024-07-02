<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TwoWayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'reply' => $this->reply,
            'from'  => $this->client->id == $this->from? 'client':'agent',
            'status'=> $this->status,
            'date'  => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
