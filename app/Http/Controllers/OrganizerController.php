<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use App\Model\OauthAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

use App\Http\Requests\OrganizerRequest;

use App\Model\Organizer;
use Illuminate\Http\Request;

use App\Exceptions\UnathorizedException;
use Illuminate\Support\Facades\Auth;
use function Sodium\randombytes_random16;

class OrganizerController extends Controller

{

    public function login(Request $request){

        $credentials=request(['name','email','password']);
        $organizer=Organizer::where('email',$credentials['email'])->first();
        $id=$organizer->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        if($token) {
            $token->delete();
        }
        if($organizer){
            if(Hash::check($credentials['password'],$organizer->password)){
                $accessToken=$organizer->createToken($organizer->name)->accessToken;
                return response(['success'=>true,'token'=>$accessToken]);
            }
        }
        }
        public function logout(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $id=$organizer->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        $token->delete();
        return response()->json(['data'=>'Token Deleted']);
    }

    public function store(OrganizerRequest $request)
    {
        $organizer= new Organizer;
        $organizer->name=$request->name;
        $organizer->description=$request->description;
        $organizer->email=$request->email;
        $organizer->password=bcrypt($request->password);
        $organizer->phone_no=$request->phone_no;
        $picture = $request->picture;  // your base64 encoded
        if($picture) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $picture);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = rand() . '.png';
            Storage::disk('public/organizer')->put($pictureName, base64_decode($picture));
            $organizer->picture = $pictureName;
        }
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
        $updatePic=$request->picture;
//        dd($request);
        if($updatePic) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $updatePic);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = rand() . '.png';
            Storage::disk('public/organizer')->put($pictureName, base64_decode($picture));
            $request->picture = $pictureName;
            $organizer->update([
                'name' => $request->name,
                'description' => $request->description,
                'picture' => $request->picture,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => bcrypt($request->password)
            ]);
        }else{
            $organizer->update($request->all());
        }
        return response([
            'data'=> $organizer,
        ],201);
    }

    public function destroy(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $pic=$organizer->picture;
        Storage::disk('public/organizer')->delete($pic);
        $organizer->delete();
        return response()->json(['data'=>'deleted']);
    }
    public function OrganizerChecker($organizer){

        if (Auth::id() !== $organizer->id){
            throw new UnathorizedException;
        }
    }
}
