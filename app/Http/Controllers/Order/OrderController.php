<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Make an order and server get it and .
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(OrderRequest $request)
    {
        $request = $request->validated();

        try {
            $order = Order::create([
                'orderer_id'            => $request['orderer_id'],
                'pick_up_detail'        => $request['pick_up_detail'],
                'pick_up_latitude'      => $request['pick_up_latitude'],
                'pick_up_longtitude'    => $request['pick_up_longtitude'],
                'drop_off_detail'       => $request['pick_up_detail'],
                'drop_off_latitude'     => $request['drop_off_latitude'],
                'drop_off_longtitude'   => $request['drop_off_longtitude'],
                'status'                => $request['status'],
            ]);
    
            return $this->respon('success', 'Created Successfully', null , [
                'status_code'   => 201,
                'status'        => $order->status,
            ] , 201);
        } catch (\Throwable $th) {
            
        }
        
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
