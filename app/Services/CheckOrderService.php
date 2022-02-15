<?php
namespace App\Services;

use App\Models\Order;

class CheckOrderService {

    public function CheckOnProcessOrder($user)
    {
        try {
            $order = Order::where('orderer_id', $user)
            ->where('status', '!=', 'dropped')
            ->latest()
            ->first();
        } catch (\Throwable $th) {
            return ['error', $th];
        }

        return ($order == null) ? [null, $order] : ['success', $order];
    }

    public function CheckOrder($order)
    {
        try {
            $order = Order::findOrFail($order['order_id']);
        } catch (\Throwable $th) {
            return [true, $th];
        }
        return [false, $order];
    }
}