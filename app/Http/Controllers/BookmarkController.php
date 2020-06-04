<?php

namespace App\Http\Controllers;

use App\Model\Bookmark;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values=request(['user_id','event_id']);
        $main=Bookmark::query()->where('user_id',$values['user_id'])->where('event_id',$values['event_id'])->count();
        if($main==0){
            $bookmark= new Bookmark();
            $bookmark->event_id=$request->event_id;
            $bookmark->user_id=$request->user_id;



            $bookmark->save();
            return response(['success'=>true]);

        }
        else{
            return response(['success'=>false]);
        }

    }

    public function checkBookmark(Request $request)
    {
        $values = request(['user_id', 'event_id']);
        $main = Bookmark::query()->where('user_id', $values['user_id'])->where('event_id', $values['event_id'])->count();
        if($main==0){
            return response(['success'=>true]);
        }else{
            return response(['success'=>false]);
        }
    }
    public function getUserBookmark(User $user){
        return $user->bookmarks->pluck('event_id');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark,User $user)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroyId(Request $request){
        $values = request(['user_id', 'event_id']);
        $bookmark=Bookmark::query()->where('user_id', $values['user_id'])->where('event_id', $values['event_id'])->pluck('id');
        $this->destroy($bookmark);
    }
    public function destroy($bookmark)
    {
       DB::table('bookmarks')->delete($bookmark);



    }
}
