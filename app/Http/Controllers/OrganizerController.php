<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use App\Model\OauthAccessToken;
use Illuminate\Support\Facades\Hash;


use App\Http\Requests\OrganizerRequest;

use App\Model\Organizer;
use Illuminate\Http\Request;

use App\Exceptions\UnathorizedException;
use Illuminate\Support\Facades\Auth;


/**
 * Class OrganizerController
 * @package App\Http\Controllers
 */
class OrganizerController extends Controller

{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request){

        $credentials=request(['name','email','password']);
        $organizer=Organizer::where('email',$credentials['email'])->first();
        if($organizer){
        $id=$organizer->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        if($token) {
            $token->delete();
        }

        if(Hash::check($credentials['password'],$organizer->password)){
            $token=OauthAccessToken::where('user_id',$id)->first();
            if($token) {
                $token->delete();
            }
            $accessToken=$organizer->createToken($organizer->name)->accessToken;
            return response(['success'=>true,'id'=>$id,'token'=>$accessToken]);
            }else{
            return response(['success'=>false]);
        }
        }
    }

    /**
     * @param Organizer $organizer
     * @return \Illuminate\Http\JsonResponse
     * @throws UnathorizedException
     */
    public function logout(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $id=$organizer->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        $token->delete();
        return response()->json(['data'=>'Token Deleted']);
    }

    /**
     * @param OrganizerRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \SMartins\PassportMultiauth\Exceptions\MissingConfigException
     */
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
            $pictureName = $organizer->email.rand() . '.png';
            Storage::disk('public')->put($pictureName, base64_decode($picture));
            $organizer->picture = $pictureName;
        }
        $organizer->save();
        $accessToken=$organizer->createToken($request->name)->accessToken;
        return response(['success'=>true,
            'id'=> $organizer->id,
            'access-token'=>$accessToken
        ],201);
    }

    /**
     * @param Organizer $organizer
     * @return Organizer
     */
    public function show(Organizer $organizer)
    {
        return $organizer;
    }


    /**
     * @param Request $request
     * @param Organizer $organizer
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws UnathorizedException
     */
    public function update(Request $request, Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $updatePic=$request->picture;
//        dd($request);
        if($updatePic) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $updatePic);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = $organizer->email.rand() . '.png';
            Storage::disk('public')->put($pictureName, base64_decode($picture));
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

    /**
     * @param Organizer $organizer
     * @return \Illuminate\Http\JsonResponse
     * @throws UnathorizedException
     */
    public function destroy(Organizer $organizer)
    {
        $this->OrganizerChecker($organizer);
        $pic=$organizer->picture;
        Storage::disk('public')->delete($pic);
        $organizer->delete();
        return response()->json(['data'=>'deleted']);
    }

    /**
     * @param $organizer
     * @throws UnathorizedException
     */
    private function OrganizerChecker($organizer){

        if (Auth::id() !== $organizer->id){
            throw new UnathorizedException;
        }
    }
}
