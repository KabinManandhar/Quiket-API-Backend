<?php

namespace App\Http\Controllers;


use App\OauthAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

use App\Http\Requests\OrganizerRequest;

use App\Model\Organizer;
use Illuminate\Http\Request;

use App\Exceptions\UnathorizedException;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller

{

    public function login(Request $request){
//        dd(Auth::guard('organizer'));
        $credentials=request(['name','email','password']);
        $organizer=Organizer::where('email',$credentials['email'])->first();
        $id=$organizer->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        if($token) {
            $token->delete();
        }
        if($organizer){
//            dd(Hash::check($credentials['password'],$organizer->password));
            if(Hash::check($credentials['password'],$organizer->password)){
                $accessToken=$organizer->createToken($request->name)->accessToken;
                return response(['success'=>true,'token'=>$accessToken]);
            }
        }
        }
        public function logout(Organizer $organizer)
    {
        dd($organizer);
        $this->OrganizerChecker($organizer);
        $organizer->delete();
        return response()->json(['data'=>'deleted']);
    }



    public function index()
    {
        return Organizer::all();
    }

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
        $accessToken=$organizer->createToken($request->name)->accessToken;
        return response([
            'data'=> $organizer,
            'access-token'=>$accessToken
        ],201);
    }

    public function show(Organizer $organizer)
    {
        return $organizer;
    }


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
            'data'=> new $organizer,
        ],201);
    }

    public function destroy(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $organizer->delete();
        return response()->json(['data'=>'deleted']);
    }
    public function OrganizerChecker($organizer){
        dd(Auth::id());
        if (Auth::id() !== $organizer->id){
            throw new UnathorizedException;
        }
    }
}
