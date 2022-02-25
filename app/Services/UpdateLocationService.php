<?php
namespace App\Services;

use App\Models\User;
use Exception;

class UpdateLocationService {

    public function UpdateLocation($id, $request)
    {
        try {
            $user = User::findOrFail($id); 
            
            ($user !== NULL) ? $user->update([
                'latitude'  => $request['latitude'],
                'longitude' => $request['longitude'],
            ]) : throw new Exception("There is no user with that data");
        } catch (\Throwable $th) {
            throw $th; 
        }
    }
}