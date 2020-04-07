<?php

namespace App\Http\Controllers;

use App\Exceptions\UnathorizedException;
use App\Http\Requests\EventRequest;
use App\Model\Event;
use App\Model\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


/**
 * Class EventController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{


    public function index()
    {
        return Event::all('id')->pluck('id');
    }



    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event= new Event;
        $event->name=$request->name;
        $event->description=$request->description;
        $event->venue=$request->venue;
        $event->category=$request->category;
        $event->type=$request->type;
        $event->status=$request->status;
        $event->start_datetime=$request->start_datetime;
        $event->end_datetime=$request->end_datetime;
        $event->organizer_id=$request->organizer_id;
        $picture = $request->picture;  //  base64 encoded
        if($picture) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $picture);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = date('mdYHis').uniqid(). '.png';
            Storage::disk('public')->put($pictureName, base64_decode($picture));
            $event->picture = $pictureName;
        }
        $event->save();
        return response(['success'=>true],201);
    }

    /**
     * @param Organizer $organizer
     * @return mixed
     */
    public function showOrganizerEvent(Organizer $organizer)
    {
        return $organizer->events->pluck('id');
    }


    /**
     * @param Event $event
     */
    public function show(Event $event)
    {
        if($event->picture) {
//            $type = pathinfo($event->picture, PATHINFO_EXTENSION);
           // $path=Storage::disk('public')->get($event->picture);
//            $base64 = base64_encode($path);
           // $image= asset('storage/public/'.$event->picture);
            $picture=Storage::url(''.$event->picture);

            return response([
                'id'=>$event->id,
                'name' => $event->name,
                'description' => $event->description,
                'picture' => $picture,
                'venue' => $event->venue,
                'category' => $event->category,
                'type' => $event->type,
                'status' => $event->status,
                'start_datetime' => $event->start_datetime,
                'end_datetime' => $event->end_datetime,
                'organizer_id' => $event->id]);
        }
        else{
            return $event;
        }
    }

    /**
     * @param Request $request
     * @param Organizer $organizer
     * @param Event $event
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws UnathorizedException
     */
    public function update(Request $request, Organizer $organizer, Event $event)
    {

        $this->OrganizerChecker($organizer);
        if($event->organizer_id == $request->organizer_id) {
            $updatePic = $request->picture;
            if ($updatePic) {
                $picture = preg_replace('/^data:image\/\w+;base64,/', '', $updatePic);
                $picture = str_replace(' ', '+', $picture);
                $pictureName = date('mdYHis').uniqid(). '.png';
                Storage::disk('public')->delete($event->picture);
                Storage::disk('public')->put($pictureName, base64_decode($picture));
                $request->picture = $pictureName;

                $event->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'picture' => $request->picture,
                    'venue' => $request->venue,
                    'category' => $request->category,
                    'type' => $request->type,
                    'status' => $request->status,
                    'start_datetime' => $request->start_datetime,
                    'end_datetime' => $request->end_datetime,
                    'organizer_id' => $organizer->id,
                ]);
            } else if(!$updatePic) {
                    $event->update($request->all());
            }
            return response(['success'=>true], 201);
        }
        else{
            return response(['error'=>"Event doesn't belong to you."]);
        }

    }


    /**
     * @param Organizer $organizer
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws UnathorizedException
     */
    public function destroy(Organizer $organizer,Event $event)
    {

       $this->OrganizerChecker($organizer);
       if($event->organizer_id == $organizer->id) {

           $pic = $event->picture;
           if ($pic) {
               Storage::disk('public')->delete($pic);
           }
           $event->delete();
           return response()->json(['data' => 'deleted']);
       }
       else{
           return response(['error'=>"Event doesn't belong to you."]);
       }
    }
    public function showTicket(Event $event){
        return $event->tickets;
    }

    /**
     * @param $organizer
     * @throws UnathorizedException
     */
    private function OrganizerChecker($organizer)
    {
        if (Auth::id() !== $organizer->id) {
            throw new UnathorizedException;

        }
    }
}
