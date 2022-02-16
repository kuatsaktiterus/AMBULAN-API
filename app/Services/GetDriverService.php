<?php
namespace App\Services;

use App\Models\Driver;
use Exception;

class GetDriverService {

    public function getDriver($latitude, $longitude, $radius = 1)
    {
        try {
            $formula =  "6371 * acos(cos(radians(" . $latitude . ")) 
                        * cos(radians(latitude)) 
                        * cos(radians(longitude) - radians(" . $longitude . ")) 
                        + sin(radians(" .$latitude. ")) 
                        * sin(radians(latitude)))";
            
            $driver = Driver::whereRaw("($formula) < $radius")
                        ->where('is_ordered', false)
                        ->orderByRaw($formula)
                        ->first();
        
            if ($radius > 10) {
                throw new Exception("No driver availabele for now");
            }
        } catch (\Throwable $th) {
            $th->is_error = true;
            return $th;
        }

        if ($driver == null) {
            $driver = $this->getDriver($latitude, $longitude, $radius+=1);
        }
        return $driver;
    }
}