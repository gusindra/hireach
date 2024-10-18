<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillingUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('billing_users')->insert([
            'name' => 'John Doe',
            'tax_id' => '1234567890',
            'post_code' => '12345',
            'province' => 'Province A',
            'city' => 'City A',
            'address' => '123 Main Street',
            'user_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type' => 'prepaid',
        ]);
    }
}
