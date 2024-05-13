<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
        UserTableSeeder::class,
        ClientSeeder::class,
        AudienceSeeder::class,
        RoleSeeder::class,
        RoleUserSeeder::class,
        PermissionSeeder::class,
        PermissionRoleSeeder::class,
       ]);
    }
}
