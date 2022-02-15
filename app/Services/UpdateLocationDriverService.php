<?php
namespace App\Services;

use App\Models\User;
use Exception;

class UpdateLocationDriverService {

    public function UpdateLocationDriver($user, $request)
    {
        try {
            $driver = User::findOrFail($user)->driver; 
            
            $location = ($driver !== NULL) ? $driver->update([
                'latitude'  => $request['latitude'],
                'longitude' => $request['longitude'],
            ]) : throw new Exception("There is no driver with that data");
            return [true, null]; 
        } catch (\Throwable $th) {
            return [false, $th]; 
        }
    }
}