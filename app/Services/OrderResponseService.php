<?php
namespace App\Services;


class OrderResponseService {
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
                'is_ordered'        => $response->customer->user->is_ordered,
                'name'          => $response->customer->user->name,
                'phone_number'  => $response->customer->user->phone_number,
            ],
            'status'        => $response->status,
        ];
    }

    public function checkAcceptedOrderResponse($isAccepted)
    {
        return [
            'status_code'   => 200,
            'order_id'      => $isAccepted->order->id,
            'order_status'  => $isAccepted->order->status,
            'driver'        => [
                'id'                    => $isAccepted->driver->id,
                'name'                  => $isAccepted->driver->user->name,
                'vehicle_name'          => $isAccepted->driver->vehicle_name,
                'registration_number'   => $isAccepted->driver->registration_number,
                'latitude'              => $isAccepted->driver->user->latitude,
                'longitude'             => $isAccepted->driver->user->longitude,
            ]
        ];
    }

    public function isAcceptOrder($order)
    {
        return [
            'status_code'   => 200,
            'order_id'      => $order->id,
            'status'        => $order->status,
        ];
    }
}