<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Hireach',
            'slug' => 'hireach'
        ]);
        Team::create([
            'user_id' => 2,
            'id' => 2,
            'name' => 'User',
            'slug' => 'User'
        ]);

        Team::create([
            'user_id' => 3,
            'id' => 3,
            'personal_team' => true,
            'name' => 'Test Team',
            'slug' => 'test-team'
        ]);
    }
}
