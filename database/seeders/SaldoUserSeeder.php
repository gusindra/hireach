<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaldoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('saldo_users')->insert([
            [
                'user_id' => 2,
                'team_id' => null,
                'model' => null,
                'model_id' => null,
                'mutation' => 'credit',
                'description' => 'Topup Test for api campaign Test',
                'currency' => 'idr',
                'amount' => 10000000.00,
                'balance' => 10000000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
