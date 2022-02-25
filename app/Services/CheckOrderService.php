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
            throw $th;
        }
        return $order;
    }
}