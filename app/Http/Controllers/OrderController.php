<?php

namespace App\Http\Controllers;

use App\Model\Event;
use App\Model\Order;
use App\Model\Ticket;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Order::all()->where('id'==2);

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

    public function showEventOrder(Event $event)
    {
        return $event->orders->pluck('id');
    }
    public function showEventOrderCount(Event $event)
    {
        return $event->orders->pluck('id')->count();
    }
    public function showUserOrder(User $user)
    {
        return $user->orders->pluck('id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order= new Order;
        $order->ticket_id=$request->ticket_id;
        $order->user_id=$request->user_id;
        $order->status=$request->status;
        $order->qr_code=$request->qr_code;

        $order->save();
        return response(['success'=>true]);
    }

    public function qrChecker(Request $request)
    {
        $qrCode=$request->qr_code;
        $order=Order::where('qr_code',$qrCode)->first();
        if($order){
            $status=$order->status;
            $orderId=$order->id;
            if($status==0){
                return response(['success'=>true,'id'=>$orderId]);
            }else{
                return response(['success'=>false,'id'=>$orderId]);
            }
        }
        return response(['error'=>true]);
    }


    public function show(Order $order)
    {
        $final=DB::table('orders')
            ->join('tickets','tickets.id','=','orders.ticket_id')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','users.name as User Name','tickets.name as Ticket Name','tickets.event_id as event_id')
            ->where('orders.id','=',$order->id)
            ->get();


        return ($final);
    }
    public function showUserTicket(Order $order)
    {
        $final=DB::table('orders')
            ->join('tickets','tickets.id','=','orders.ticket_id')
            ->join('users','users.id','=','orders.user_id')
            ->join('events','events.id','=','tickets.event_id')
            ->select('orders.*','users.name as User Name','tickets.name as Ticket Name','tickets.event_id as event_id','events.name as Event Name')
            ->where('orders.id','=',$order->id)
            ->get();


        return ($final);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response(['success'=>true], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

}
