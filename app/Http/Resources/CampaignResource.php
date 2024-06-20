<?php

namespace App\Http\Resources;

use App\Models\BlastMessage;
use App\Models\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'status'        => $this->status,
            'uuid'          => $this->uuid,
            'type'          => $this->type,
            'channel'       => $this->channel,
            'provider'      => $this->provider->code,
            'title'         => $this->title,
            'text'          => $this->text,
            'way_type'      => $this->way_type,
            'template_id'   => $this->template_id,
            'audience_id'   => $this->audience_id,
            'is_otp'        => $this->is_otp,
            'from'          => $this->from,
            'to'            => $this->to,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'request_count' => count($this->request),
            'request'   => $this->whenLoaded('request', function () {
                $array = [];
                foreach($this->request->pluck('model_id') as $key => $id){
                    $msg = BlastMessage::find($id);
                    $array[$key][0] = $msg->msisdn;
                    $array[$key][1] = $msg->status;
                }
                return $array;
            }),
        ];
    }
}
