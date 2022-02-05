<?php
namespace App\Services;

use App\Models\Order;

class CheckOrderService {

    public function CheckOrder($user)
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
}