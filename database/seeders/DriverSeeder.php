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
        Driver::create(['nama_kendaraan' => 'Yamaha NMAX', 'no_polisi_kendaraan' => 'DD 2305 XXNX', 'id_user' => 2]);
    }
}
