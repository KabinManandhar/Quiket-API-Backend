<?php

namespace App\Http\Controllers;

use App\Exceptions\UnathorizedException;
use App\Http\Requests\TicketRequest;
use App\Model\Event;
use App\Model\Organizer;
use App\Model\Ticket;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function store(TicketRequest $request)
    {
        $ticket= new Ticket;
        $ticket->name=$request->name;
        $ticket->description=$request->description;
        $ticket->price=$request->price;
        $ticket->total_ticket=$request->total_ticket;
        $ticket->max_ticket_allowed_per_person=$request->max_ticket_allowed_per_person;
        $ticket->min_ticket_allowed_per_person=$request->min_ticket_allowed_per_person;
        $ticket->status=$request->status;
//        $ticket->refundable=$request->refundable;
        $ticket->ticket_type=$request->ticket_type;
//        $ticket->promo_code=$request->promo_code;

        $ticket->event_id=$request->event_id;
        $ticket->save();
        return response([
            'success'=>true
        ],201);
    }


    public function show(Ticket $ticket)
    {
        return $ticket;
    }

    public function showEventTicket(Event $event)
    {
        return $event->tickets->pluck('id');
    }



    public function update(Request $request,Organizer $organizer, Ticket $ticket)
    {
        $this->OrganizerChecker($organizer);
        $ticket->update($request->all());
        return response([
            'success' => true,
            ], 201);
        }







    public function destroy(Organizer $organizer,Event $event,Ticket $ticket)
    {
        $this->OrganizerChecker($organizer);
        if($event->id==$ticket->event_id) {
            $ticket->delete();
            return response()->json(['data' => 'deleted']);
        }else{
            return response()->json(['error' => 'Cannot Delete']);
        }
    }

    private function OrganizerChecker($organizer){

        if (Auth::id() !== $organizer->id){
            throw new UnathorizedException;
        }
    }
}
