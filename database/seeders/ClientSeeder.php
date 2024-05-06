<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'uuid' => Str::uuid(),
            'sender' => 'Example Sender',
            'name' => 'Example Client',
            'phone' => '123',
            'identity' => 'Example Identity',
            'user_id' => 1,
            'note' => 'Example Note',
            'tag' => 'Example Tag',
            'email' => 'example@example.com',
            'address' => 'Example Address',
            'title' => 'Example Title',
        ]);
    }
}
