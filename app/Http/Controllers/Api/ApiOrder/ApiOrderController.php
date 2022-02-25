<?php

namespace App\Http\Controllers\Api\ApiOrder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\OrderController;
use App\Http\Requests\CheckOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Services\CheckOrderService;
use App\Services\OrderResponseService;
use Illuminate\Http\Request;

class ApiOrderController extends Controller
{
    private $checkOrderService;
    private $OrderResponseService;
    private $orderController;

    public function __construct()
    {
        // parent::__construct();

        $this->checkOrderService = new CheckOrderService;
        $this->OrderResponseService = new OrderResponseService; 
        $this->orderController = new OrderController;
    }

    /**
     * Store order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Http\Requests\StoreOrderRequest  $storeOrderReq
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(Request $request, StoreOrderRequest $storeOrderReq)
    {
        $storeOrderReq = $storeOrderReq->validated();
        $user = $request->user();
        
        try {
            if ($user->is_ordered == true) {
                $checkOrder = $this->checkOrderService->CheckOnProcessOrder($user->id);
                if($checkOrder){
                    return $this->respon('success', 'Already Ordered', null ,$this->OrderResponseService->checkOrderResponse($checkOrder) , 201);
                }
            }
            $order = $this->orderController->store($request, $user);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }

        return $this->respon('success', 'Order Created Successfully', null , $this->OrderResponseService->checkOrderResponse($order) , 201);
    }

    /**
     * Checking if order already accepted.
     *
     * @param  App\Http\Requests\CheckOrderRequest  $checkOrderReq
     * @return \Illuminate\Http\Response
     */
    public function checkAcceptedOrder(CheckOrderRequest $request)
    {
        $request = $request->validated();

        try {
            $order = $this->orderController->GetOrder($request);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500);
        }

        $orderAcceptedLog = $order->OrderAcceptedLog;

        return ($orderAcceptedLog->is_accepted == false) 
        ? $this->respon('success', 'order not accepted', null, $this->OrderResponseService->checkAcceptedOrderResponse($orderAcceptedLog), 200) 
        : $this->respon('success', 'order already accepted', null, $this->OrderResponseService->checkAcceptedOrderResponse($orderAcceptedLog) , 200);
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
