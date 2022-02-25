<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'         =>'ricky',
            'phone_number'  => '12345678',
            'role'          => 'customer',
            'password'      => Hash::make(12345678),
            'is_ordered'    => true],

            ['name'         => 'ancung',
            'phone_number'  => '123456789',
            'role'          => 'driver',
            'password'      => Hash::make(12345678),
            'latitude'      => -5.147665,
            'longitude'     => 119.432732,
            'is_ordered'    => true]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        
    }
}
