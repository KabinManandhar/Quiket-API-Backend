<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator;

use App\Http\Requests\OrganizerRequest;
use App\Http\Resources\Organizer\OrganizerCollection;
use App\Http\Resources\Organizer\OrganizerResource;
use App\Model\Organizer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Exceptions\UnathorizedException;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */


    public function index()
    {
        return OrganizerCollection::collection(Organizer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @param OrganizerRequest $request
     */
    public function store(OrganizerRequest $request)
    {
        $organizer= new Organizer;
        $organizer->name=$request->name;
        $organizer->description=$request->description;
        $organizer->email=$request->email;
        $organizer->password=bcrypt($request->password);
        //$organizer->password_confirmation=bcrypt($request->password_confirmation);
        $organizer->phone_no=$request->phone_no;
        $organizer->save();
        $accessToken=$organizer->createToken('test')->accessToken;
        return response([
            'data'=> new OrganizerResource($organizer),
            'access-token'=>$accessToken
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param Organizer $organizer
     * @return OrganizerResource
     */
    public function show(Organizer $organizer)
    {
        return new OrganizerResource($organizer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $organizer->update([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $request->picture,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => bcrypt($request->password)
        ]);
        //$organizer->update($request->all());
        return response([
            'data'=> new OrganizerResource($organizer)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Organizer $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $organizer->delete();
        return response()->json(['data'=>'deleted']);
    }
    public function OrganizerChecker($organizer){
        if (Auth::id() !== $organizer->id){
            throw new UnathorizedException;
        }
    }
}
