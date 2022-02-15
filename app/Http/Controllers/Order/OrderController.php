<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Driver;
use App\Models\Order;
use App\Services\CheckOrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Make an order from user.
     * @param  App\Http\Requests\StoreOrderRequest  $storeOrderReq
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */

    private $checkOrderService;

    public function __construct()
    {
        // parent::__construct();

        $this->checkOrderService = new CheckOrderService; 
    }

    public function storeOrder(Request $request, StoreOrderRequest $storeOrderReq)
    {
        $storeOrderReq = $storeOrderReq->validated();
        $userId = $request->user()->customer->id;
        $checkOrder = $this->checkOrderService->CheckOnProcessOrder($userId);

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
        $checkOrderService = $this->checkOrderService->checkOrder($checkOrderReq);

        return ($checkOrderService[0]) ?
        $this->respon('error', 'error', $checkOrderService[1]->getMessage(), null , 500) :
        $this->respon('success', 'Order Callback Successfully', null, $this->checkOrderResponse($checkOrderService[1]), 200);
    }

    /**
     * checking is there on process order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function isOnProcessOrder(Request $request)
    {
        $user = $request->user();
        $order = $this->checkOrderService->CheckOnProcessOrder($user->id);

        if ($order[0] == 'error') {
            return $this->respon('error', 'error', $order[1]->getMessage(), null , 500);
        } elseif ($order[0] == 'success') {
            return $this->respon('success', 'Order Callback Successfully', null, $this->checkOrderResponse($order[1]) , 200);
        } elseif ($order[0] == null) {
            return $this->respon('success', 'No Order On Progress', null, null , 200);
        }
    }

    /**
     * Checking if order already accepted.
     *
     * @param  App\Http\Requests\CheckOrderRequest  $checkOrderReq
     * @return \Illuminate\Http\Response
     */
    public function isOrderAccepted(CheckOrderRequest $request)
    {
        $request = $request->validated();

        try {
            $order = Order::findOrfail($request['order_id']);
            $isAccepted = $order->OrderAcceptedLog->is_accepted;
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }

        return ($isAccepted === false) ? $this->respon('success', 'order not accepted', null, [
            'status_code'   => 200,
            'order_id'      => $order->id,
        ] , 200) :
        $this->respon('success', 'order already accepted', null, [
            'status_code'   => 200,
            'order_id'      => $isAccepted->order->id,
            'driver'        => [
                'name'                  => $isAccepted->driver->user->name,
                'vehicle_name'          => $isAccepted->driver->vehicle_name,
                'registration_number'   => $isAccepted->driver->registration_number,
                'latitude'              => $isAccepted->driver->latitude,
                'longitude'             => $isAccepted->driver->longitude,
            ]
        ] , 200);
    }

    /**
     * Get the driver for order.
     *
     * @param  App\Http\Requests\CheckOrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getDriver(CheckOrderRequest $request, int $radius=100)
    {
        $order = $this->checkOrderService->CheckOrder($request);
        
        if ($order[0]) {return $this->respon('error', 'error', $order[1]->getMessage(), null , 500);}
        
        $latitude = $order[1]->pick_up_latitude;
        $longitude = $order[1]->pick_up_longitude;

        $driver = Driver::whereRaw("ACOS(SIN(RADIANS('latitude'))*SIN(RADIANS($latitude))
                                  +COS(RADIANS('latitude'))*COS(RADIANS($latitude))
                                  *COS(RADIANS('longitude')-RADIANS($longitude)))*6380 < $radius")->first();

        if ($driver === null) {
            return $this->getDriver($request, $radius*=10);
        }
        
        $driver->update(['is_ordered' => true]);
        return $this->respon('success', 'Driver found', null, [
            'status_code'   => 200,
            'driver_id'     => $driver->id,
        ], 200);
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
