<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('my-channel.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('get-driver-channel.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('is-driver-accept-channel.{orderId}', function ($user, $orderId) {
    return (int) $user->id === (int) Order::findOrFail($orderId)->customer->customer_id;
});

Broadcast::channel('change-status-order-channel.{orderId}', function ($user, $orderId) {
    return (int) $user->id === (int) Order::findOrFail($orderId)->customer->customer_id;
});