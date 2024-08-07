<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'name' => 'Super Admin',
                'role_for' => 'admin',
                'description' => 'All permisison role'
            ],
            [
                'name' => 'Admin',
                'role_for' => 'admin',
                'description' => 'All permisison role in the team'
            ],
            [
                'name' => 'Agent',
                'role_for' => 'team',
                'description' => 'All permisison for the chat'
            ],
            [
                'name' => 'Admin Project Manager',
                'role_for' => 'team',
                'description' => 'All permisison for the project,'
            ],
            [
                'name' => 'Admin Operational Manager',
                'role_for' => 'team',
                'description' => 'All permisison for the project operational'
            ],
            [
                'name' => 'Admin Commercial Manager',
                'role_for' => 'team',
                'description' => 'All permisison to for the project commercial'
            ],
            [
                'name' => 'Admin Accounting',
                'role_for' => 'team',
                'description' => 'Permisison only for billing'
            ]
        );

        DB::table('roles')->insert($data);
    }
}

