<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Driver::create(['vehicle_name' => 'Yamaha NMAX', 
                        'registration_number' => 'DD 2305 XXNX',
                        'user_id' => 2,
                        ]);
    }
}
