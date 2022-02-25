<?php

namespace Database\Seeders;

use App\Models\OrderAcceptedLog;
use Illuminate\Database\Seeder;

class OrderAcceptedLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderAcceptedLog::create(['order_id' => 1, 'driver_id'  => 1, 'is_accepted' => true]);
    }
}
