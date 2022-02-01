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
            ['nama'     =>'ricky',
            'no_hp'     => '12345678',
            'role'      => 'customer',
            'password'  => Hash::make(12345678)],

            ['nama'     => 'ancung',
            'no_hp'     => '123456789',
            'role'      => 'driver',
            'password'  => Hash::make(12345678)],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        
    }
}
