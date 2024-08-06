<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert([
            ['id' => 1, 'code' => 'provider1', 'name' => 'Macrokiosk Telixcel OTP', 'channel' => 'SMS_OTP'],
            ['id' => 2, 'code' => 'provider1', 'name' => 'Macrokiosk Telixcel NONOTP', 'channel' => 'SMS_OTP,SMS'],
            ['id' => 3, 'code' => 'provider1', 'name' => 'smtp2go', 'channel' => 'EMAIL'],
            ['id' => 4, 'code' => 'provider2', 'name' => 'enjoymov', 'channel' => 'LONG_WA,LONG_SMS'],
            ['id' => 5, 'code' => 'provider3', 'name' => 'forCampaign', 'channel' => 'LONG_WA,LONG_SMS'],
        ]);
    }
}
