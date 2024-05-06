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
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'User Hireach',
            'email' => 'user@hireach.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
