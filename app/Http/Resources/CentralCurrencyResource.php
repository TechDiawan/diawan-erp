<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CentralCurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'rate' => $this->rate,
            'symbol' => $this->symbol,
            'position' => $this->position,
            'label' => $this->position == 'left' ? $this->code.' ('.$this->symbol.'0.00)' : $this->code.' (0.00'.$this->symbol.')',
            'note' => $this->note,
            'status' => (int) $this->status,
        ];
    }
}
