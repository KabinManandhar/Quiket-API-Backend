<?php

namespace App\Http\Controllers;

use App\Exceptions\UnathorizedException;
use App\Http\Requests\UserRequest;

use App\Model\OauthAccessToken;
use App\Model\Organizer;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function login(Request $request){

        $credentials=request(['name','email','password']);
        $user=User::where('email',$credentials['email'])->first();
        $id=$user->id;
        $name=$user->name;
        $token=OauthAccessToken::where('name',$name and 'user_id',$id)->first();
        if($token) {
            $token->delete();
        }
        if($user){
            if(Hash::check($credentials['password'],$user->password)){
                $accessToken=$user->createToken($user->name)->accessToken;
                return response(['success'=>true,'token'=>$accessToken]);
            }
        }
    }
    public function logout(Organizer $user)
    {
        $this->UserChecker($user);
        $id=$user->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        $token->delete();
        return response()->json(['data'=>'Token Deleted']);
    }


    public function store(UserRequest $request)
    {
        $user= new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $picture=$request->picture;
        if($picture) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $picture);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = rand() . '.png';
            Storage::disk('public/user')->put($pictureName, base64_decode($picture));
            $user->picture = $pictureName;
        }
        $user->phone_no=$request->phone_no;
        $user->save();
        $accessToken=$user->createToken($request->name)->accessToken;
        return response([
            'data'=> $user,
            'access-token'=>$accessToken
        ],201);
    }


    public function show(User $user)
    {
        return $user;
    }


    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function UserChecker(User $user)
    {

        if (Auth::id() !== $user->id) {
            throw new UnathorizedException;
        }
    }
}
