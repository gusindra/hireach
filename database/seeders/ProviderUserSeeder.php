<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provider_user')->insert([
            [
                'provider_id' => 5,
                'user_id' => 2,
                'channel' => 'LONG_WA',
            ],
            [
                'provider_id' => 5,
                'user_id' => 2,
                'channel' => 'LONG_SMS',
            ],
            [
                'provider_id' => 3,
                'user_id' => 2,
                'channel' => 'EMAIL',
            ],
            [
                'provider_id' => 2,
                'user_id' => 2,
                'channel' => 'SMS',
            ],
            [
                'provider_id' => 1,
                'user_id' => 2,
                'channel' => 'SMS_OTP',
            ],
        ]);
    }
}
