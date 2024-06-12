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
            ['id' => 1, 'code' => 'TCI01', 'name' => 'Macrokiosk Telixcel OTP', 'channel' => 'SMS_OTP'],
            ['id' => 2, 'code' => 'TCI02', 'name' => 'Macrokiosk Telixcel NONOTP', 'channel' => 'SMS_OTP,SMS'],
            ['id' => 3, 'code' => 'EMAIL1', 'name' => 'smtp2go', 'channel' => 'EMAIL'],
            ['id' => 4, 'code' => 'KSTB904790', 'name' => 'enjoymov', 'channel' => 'LONG_WA,LONG_SMS'],
        ]);
    }
}
