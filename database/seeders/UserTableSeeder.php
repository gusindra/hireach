<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Hireach',
            'email' => 'admin@hireach.com',
            'phone_no' => '99999999',

            'password' => Hash::make('12345678'),
            'current_team_id' => 1
        ]);

        User::create([
            'name' => 'User Hireach',
            'email' => 'user@hireach.com',
            'phone_no' => '99888888',
            'password' => Hash::make('12345678'),
            'current_team_id' => 2
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user1@hireach.com',
            'password' => Hash::make('12345678'),
            'current_team_id' => 0
        ]);

          User::create([
            'name' => 'User 4',
            'email' => 'user4@hireach.com',
            'password' => Hash::make('12345678'),
            'current_team_id' => 2
        ]);
    }
}
