<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\CheckOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Make an order from user.
     * @param  App\Http\Requests\StoreOrderRequest  $storeOrderReq
     * @param  Illuminate\Http\Request  $request
     * @param  App\Services\CheckOrderService  $checkOrderService
     * @return \Illuminate\Http\Response
     * 
     */
    public function storeOrder(Request $request, StoreOrderRequest $storeOrderReq, CheckOrderService $checkOrderService)
    {
        $storeOrderReq = $storeOrderReq->validated();
        $userId = $request->user()->id;
        $checkOrder = $checkOrderService->checkOrder($userId);

        if ($checkOrder[0] == 'error') {
            return $this->respon('error', 'error', $checkOrder[1]->getMessage(), null , 500);
        } elseif ($checkOrder[0] == 'success') {
            return $this->respon('success', 'Already Ordered', null, $this->checkOrderResponse($checkOrder[1]) , 200);
        }

        try {
            $order = Order::create([
                'orderer_id'            => $userId,
                'pick_up_detail'        => $request['pick_up_detail'],
                'pick_up_latitude'      => $request['pick_up_latitude'],
                'pick_up_longitude'     => $request['pick_up_longitude'],
                'drop_off_detail'       => $request['pick_up_detail'],
                'drop_off_latitude'     => $request['drop_off_latitude'],
                'drop_off_longitude'    => $request['drop_off_longitude'],
            ]);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }

        return $this->respon('success', 'Order Created Successfully', null , [
            'status_code'   => 201,
            'order_id'      => $order->id,
            'status'        => $order->status,
        ] , 201);
    }

    /**
     * checking order.
     *
     * @param  App\Http\Requests\CheckOrderRequest  $checkOrderReq
     * @return \Illuminate\Http\Response
     * 
     */
    public function checkOrder(CheckOrderRequest $checkOrderReq)
    {
        $checkOrderReq = $checkOrderReq->validated();
        try {
            $order = Order::findOrFail($checkOrderReq['order_id']);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
            
        }
        return $this->respon('success', 'Order Callback Successfully', null, $this->checkOrderResponse($order), 200);
    }

    /**
     * checking is there on process order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function isOnProcessOrder(Request $request, CheckOrderService $checkOrderService)
    {
        $user = $request->user();
        $order = $checkOrderService->CheckOrder($user->id);

        if ($order[0] == 'error') {
            return $this->respon('error', 'error', $order[1]->getMessage(), null , 500);
        } elseif ($order[0] == 'success') {
            return $this->respon('success', 'Order Callback Successfully', null, $this->checkOrderResponse($order[1]) , 200);
        } elseif ($order[0] == null) {
            return $this->respon('success', 'No Order On Progress', null, null , 200);
        }
    }

    /**
     * Response of checking order.
     * @return array<int, string>
     *
     */
    public function checkOrderResponse($response)
    {
        return [
            'status_code'   => 200,
            'order_id'      => $response->id,
            'pick_up'       => [
                'detail'    => $response->pick_up_detail,
                'latitude'  => $response->pick_up_latitude,
                'longitude' => $response->pick_up_longitude,
            ],
            'drop_off'      => [
                'detail'    => $response->pick_up_detail,
                'latitude'  => $response->drop_off_latitude,
                'longitude' => $response->drop_off_longitude,
            ],
            'orderer'       => [
                'id'            => $response->customer->id,
                'status'        => $response->customer->status,
                'name'          => $response->customer->user->name,
                'phone_number'  => $response->customer->user->phone_number,
            ],
            'status'        => $response->status,
        ];
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
