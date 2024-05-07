<?php

namespace Database\Seeders;

use App\Models\Audience;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(2);
        Audience::create([
            'name' => 'For Contact',
            'description' => 'Example Description For Contact',
            'user_id' => $user->id
        ]);
    }
}
