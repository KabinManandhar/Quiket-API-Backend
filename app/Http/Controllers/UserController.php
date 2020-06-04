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

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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
                return response(['success'=>true,'id'=>$user->id,'token'=>$accessToken]);
            }else{
                return response(['success'=>false]);
            }
        }
    }

    /**
     * @param Organizer $user
     * @return \Illuminate\Http\JsonResponse
     * @throws UnathorizedException
     */
    public function logout(User $user)
    {
        $this->UserChecker($user);
        $id=$user->id;
        $token=OauthAccessToken::where('user_id',$id)->first();
        $token->delete();
        return response(['success'=>true]);
    }


    /**
     * @param UserRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \SMartins\PassportMultiauth\Exceptions\MissingConfigException
     */
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
            $pictureName = date('mdYHis').uniqid(). '.png';
            Storage::disk('public')->put($pictureName, base64_decode($picture));
            $user->picture = $pictureName;
        }
        $user->phone_no=$request->phone_no;
        $user->save();
        return response(['success'=>true]);
    }


    /**
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        $picture=Storage::url(''.$user->picture);
        return response([
            'id'=>$user->id,
            'name' => $user->name,
            'phone_no' => $user->phone_no,
            'email' => $user->email,
            'description' => $user->description,
            'picture' => $picture,
           ]);
    }



    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws UnathorizedException
     */
    public function update(Request $request, User $user)
    {

        $this->UserChecker($user);
        $updatePic=$request->picture;
//        dd($request);
        if($updatePic) {
            $picture = preg_replace('/^data:image\/\w+;base64,/', '', $updatePic);
            $picture = str_replace(' ', '+', $picture);
            $pictureName = date('mdYHis').uniqid(). '.png';
            Storage::disk('public')->delete($user->picture);
            Storage::disk('public')->put($pictureName, base64_decode($picture));
            $request->picture = $pictureName;
            $password=bcrypt($request->password);
            $user->update([
                'name' => $request->name,
                'description' => $request->description,
                'picture' => $request->picture,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => $password
            ]);
        }elseif ($request->password){
            $password=bcrypt($request->password);
            $user->update([
                'name' => $request->name,
                'description' => $request->description,
                'picture' => $request->picture,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => $password
            ]);
        }else{
            $user->update([
                'name' => ($request->name),
                'description' => $request->description,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => bcrypt($request->password)
            ]);
        }
        return response(['success'=>true,
        ],201);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws UnathorizedException
     */
    public function destroy(User $user)
    {
        $this->UserChecker($user);
        $pic=$user->picture;
        Storage::disk('public')->delete($pic);
        $user->delete();
        return response()->json(['data'=>'deleted']);
    }

    /**
     * @param User $user
     * @throws UnathorizedException
     */
    private function UserChecker(User $user)
    {

        if (Auth::id() !== $user->id) {
            throw new UnathorizedException;
        }
    }
}
