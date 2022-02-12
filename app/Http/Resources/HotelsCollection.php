<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HotelsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->collection['hotel_id'],
            'name'  => $request->language == 'ar'?$this->collection['translated_name']:$this->collection['hotel_name'],
            'geo'  =>[
                'latitude'    => $this->collection['latitude'],
                'longitude'  =>$this->collection['longitude'],
            ],
        ];
    }
}
