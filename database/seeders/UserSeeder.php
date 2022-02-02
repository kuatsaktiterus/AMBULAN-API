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
            'password'      => Hash::make(12345678)],

            ['name'         => 'ancung',
            'phone_number'  => '123456789',
            'role'          => 'driver',
            'password'      => Hash::make(12345678)],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        
    }
}
