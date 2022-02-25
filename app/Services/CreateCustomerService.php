<?php
namespace App\Services;

use App\Models\Customer;

class CreateCustomerService {

    public function CreateCustomer($user)
    {
        try {
            Customer::create([
                'customer_id'   => $user->id,
            ]);
        } catch (\Throwable $th) {
            $user->delete();
            return $th;
        }
    }
}