<?php

namespace App\Http\Controllers;

use App\Model\Event;
use App\Model\Order;
use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(Order $order)
    {
        $final=DB::table('orders')
            ->join('tickets','tickets.id','=','orders.ticket_id')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','users.name as User Name','tickets.name as Ticket Name')
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
        //
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
