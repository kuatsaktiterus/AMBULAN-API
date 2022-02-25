<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'orderer_id'            => 1,
            'pick_up_detail'        => 'di samping jembatan dekat langit',
            'pick_up_latitude'      => '-5.148366',
            'pick_up_longitude'     => '119.432863',
            'drop_off_detail'       => 'di samping jembatan dekat langit',
            'drop_off_latitude'     => '23.00078',
            'drop_off_longitude'    => '23.00078',
            'status'                => 'accepted',
        ]);
    }
}
