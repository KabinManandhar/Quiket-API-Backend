<?php

namespace App\Http\Resources\Organizer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
          return [
              'id'=>$this->id,
              'name'=>$this->name,
              'description'=>$this->description,
              'picture'=>$this->picture,
              'email'=>$this->email,
              'password'=>$this->password,
              'phone_no'=>$this->phone_no,
              'no_of_events'=>$this->events->sum('id')==0 ?'No events hosted yet.' : $this->events->sum('id'),
              'href'=>route('events.index',$this->id)
          ];
    }
}
