<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingVatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            [
                'key' => 'vat',
                'value' => '11',
                'remark' => 'Indonesia Tax',
            ],
            [
                'key' => 'min_blast',
                'value' => '3000',
                'remark' => 'for campaign wetalk',
            ],
            [
                'key' => 'min_balance_blast',
                'value' => '1500000',
                'remark' => 'minenum saldo for campaign',
            ],
            [
                'key' => 'alert_balance',
                'value' => '200000',
                'remark' => 'global alert balance',
            ],
        ]);
    }
}
