<?php
namespace App\Services;

use App\Models\Driver;
use App\Models\User;
use Exception;

class GetDriverService {

    public function getDriver($latitude, $longitude, $radius = 1)
    {
        try {
            $formula =  "6371 * acos(cos(radians(" . $latitude . ")) 
                        * cos(radians(users.latitude)) 
                        * cos(radians(longitude) - radians(" . $longitude . ")) 
                        + sin(radians(" .$latitude. ")) 
                        * sin(radians(users.latitude)))";
            
            $driver = User::join('drivers', 'users.id', '=', 'drivers.user_id')
                        ->whereRaw("($formula) < $radius")
                        ->where('is_ordered', false)
                        ->orderByRaw($formula)
                        ->first();
        
            if ($radius > 10) {
                throw new Exception("No driver available for now");
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        if ($driver == null) {
            $driver = $this->getDriver($latitude, $longitude, $radius+=1);
        }
        return $driver;
    }
}