<?php

namespace App\Http\Resources\Event;


use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name'=>$this->name,
            'description'=>$this->description,
            'picture'=>$this->picture,
            'start_datetime'=>$this->start_datetime,
            'end_datetime'=>$this->end_datetime,
            'tickets'=>$this->tickets->count('id')==0 ?'No tickets hosted yet.' : $this->tickets->count('id')

        ];}

}
