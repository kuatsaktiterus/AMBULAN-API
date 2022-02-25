<?php
namespace App\Services;

use App\Models\Order;

class IsOrderAcceptedService {

    public function IsOrderAccepted($request)
    {
        try {
            $order = Order::findOrFail($request['order_id']);
            $order->update(['status' => $request['status']]);
            $order->OrderAcceptedLog->update(['is_accepted' => $request['is_accepted']]);
        } catch (\Throwable $th) {
            return $th;
        }
        return $order;
    }
}