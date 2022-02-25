<?php
namespace App\Services;

use App\Models\Order;

class ChangeStatusOrderService {

    public function ChangeStatusOrder($request)
    {
        try {
            $order = Order::findOrFail($request['order_id']);
            $order->update(['status' => $request['status']]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $order;
    }
}