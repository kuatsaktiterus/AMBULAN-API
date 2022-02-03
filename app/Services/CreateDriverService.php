<?php
namespace App\Services;

use App\Models\Driver;

class CreateDriverService {

    public function CreateDriver($user, $request)
    {
        try {
            Driver::create([
                'vehicle_name'          => $request['vehicle_name'], 
                'registration_number'   => $request['registration_number'], 
                'user_id'               => $user->id
            ]);
    
            $user->update(['role' => 'driver']);
        } catch (\Throwable $th) {
            $user->delete();
            return $th;
        }
    }
}