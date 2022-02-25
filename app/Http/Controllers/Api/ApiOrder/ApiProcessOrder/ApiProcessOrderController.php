<?php

namespace App\Http\Controllers\Api\ApiOrder\ApiProcessOrder;

use App\Events\ChangeStatusOrderEvent;
use App\Events\GetDriverEvent;
use App\Events\IsDriverAcceptEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\OrderAcceptedLog\OrderAcceptedLogController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Requests\ChangeStatusOrderRequest;
use App\Http\Requests\CheckOrderRequest;
use App\Http\Requests\IsOrderAcceptedRequest;
use App\Services\ChangeStatusOrderService;
use App\Services\CheckOrderService;
use App\Services\GetDriverService;
use App\Services\IsOrderAcceptedService;
use App\Services\OrderResponseService;
use App\Services\UpdateStatusUserService;
use Illuminate\Http\Request;

class ApiProcessOrderController extends Controller
{
    private $orderAccCon;
    private $orderController;
    private $orderResponseService;

    public function __construct()
    {
        $this->orderAccCon = new OrderAcceptedLogController;
        $this->orderController = new OrderController;
        $this->orderResponseService = new OrderResponseService;
    }
    /**
     * Get the driver for order.
     *
     * @param  App\Http\Requests\CheckOrderRequest $request
     * @param  App\Http\Requests\OrderAcceptedLogsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getDriver(CheckOrderRequest $request)
    {
        $request = $request->validated();
        
        try {
            $order = $this->orderController->GetOrder($request);

            $latitude = $order->pick_up_latitude;
            $longitude = $order->pick_up_longitude;
            $driver = (new GetDriverService())->getDriver($latitude, $longitude);

            $OrderAccLogReq = [
                'order_id' => $request['order_id'],
                'driver_id' => $driver->id,
            ];

            if ($order->OrderAcceptedLog){
                $order->OrderAcceptedLog->update(['driver_id' => $driver->id]);
                $orderAcceptedLogs = $order->OrderAcceptedLog;
            }
            else {$orderAcceptedLogs = $this->orderAccCon->store($OrderAccLogReq);}

            (new UpdateStatusUserService)->updateStatusUserTrue($driver->user_id);
        }
        catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }   

        $response = [
            'status_code'             => 200,
            'order_accepted_logs'     => [
                'order_id'       => $orderAcceptedLogs->order_id,
                'driver_id'      => $orderAcceptedLogs->driver_id,
                'driver_user_id' => $orderAcceptedLogs->driver->user_id,
            ],
        ];
        // Melempar data ke driver setelah driver ditemukan
        event(new GetDriverEvent($response));
        return $this->respon('success', 'Driver found', null, $response, 200);
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
        try {
            $order = (new CheckOrderService)->CheckOnProcessOrder($user->id);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }

        return ($order == null) 
        ? $this->respon('success', 'No Order On Progress', null, null , 200)
        : $this->respon('success', 'Order Callback Successfully', null, (new OrderResponseService)->checkOrderResponse($order) , 200);
    }

    /**
     * Is Order Accepted By Driver.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function isAcceptOrder(IsOrderAcceptedRequest $request)
    {
        $request = $request->validated();
        $orderAccService = new IsOrderAcceptedService;
        $request = [
            'order_id'      => $request['order_id'],
            'status'        => ($request['is_accepted']) ? 'accepted' : 'rejected',
            'is_accepted'   => $request['is_accepted'],
        ];

        try {
            $order = $orderAccService->IsOrderAccepted($request);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }
        // Melempar data ke Customer setelah driver merespon request
        event(new IsDriverAcceptEvent($this->orderResponseService->isAcceptOrder($order)));
        return $this->respon('success', "Order ". $request['status'], null, $this->orderResponseService->isAcceptOrder($order), 200);
    }

    public function changeStatusOrder(ChangeStatusOrderRequest $request)
    {
        $request = $request->validated();

        try {
            $order = (new ChangeStatusOrderService)->changeStatusOrder($request);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }
        // Melempar data ke user setelah driver merubah status order
        event(new ChangeStatusOrderEvent($this->orderResponseService->isAcceptOrder($order)));
        return $this->respon('success', 'change success', null, $this->orderResponseService->isAcceptOrder($order) , 200);
    }

    /**
     * When order is finish.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function finishOrder()
    {
        
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
