<?php

namespace Database\Seeders;

use App\Models\OperatorPhoneNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OperatorPhoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperatorPhoneNumber::create([
            'code' => '62811',
            'operator' => 'Telkomsel',
        ]);

        OperatorPhoneNumber::create([
            'code' => '62812',
            'operator' => 'Telkomsel',
        ]);

        OperatorPhoneNumber::create([
            'code' => '62813',
            'operator' => 'Telkomsel',
        ]);
    }
}
