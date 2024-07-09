<?php

namespace Database\Seeders;

use App\Models\TeamUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamUser::create([
            'team_id' => 1,
            'user_id' => 1,
            'role' => 'superadmin',
        ]);

        TeamUser::create([
            'team_id' => 2,
            'user_id' => 2,
            'role' => 'admin',
        ]);
    }
}
