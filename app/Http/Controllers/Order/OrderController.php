<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Get order.
     *
     * @param  App\Http\Requests\CheckOrderRequest  $checkOrderReq
     * @return App\Models\Order 
     * 
     */
    public function GetOrder($request)
    {
        try {
            $order = Order::findOrFail($request['order_id']);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $order;
    }

    /**
     * Store order.
     *
     * @param  App\Http\Requests\StoreOrderRequest  $storeOrderReq
     * @return \Illuminate\Http\Response
     * 
     */
    public function store($request, $user)
    {
        try {
            $order = Order::create([
                'orderer_id'            => $user->id,
                'pick_up_detail'        => $request['pick_up_detail'],
                'pick_up_latitude'      => $request['pick_up_latitude'],
                'pick_up_longitude'     => $request['pick_up_longitude'],
                'drop_off_detail'       => $request['pick_up_detail'],
                'drop_off_latitude'     => $request['drop_off_latitude'],
                'drop_off_longitude'    => $request['drop_off_longitude'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $order;
    }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
