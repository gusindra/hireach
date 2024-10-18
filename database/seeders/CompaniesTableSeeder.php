<?php

namespace Database\Seeders;

use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\ProductLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Companies
        $company = Company::create([
            'name' => 'Company A',
            'code' => 'COMP-A',
            'tax_id' => '1234567890',
            'post_code' => '10000',
            'province' => 'Province A',
            'city' => 'City A',
            'address' => 'Address A',
            'logo' => 'logo_a.png',
            'person_in_charge' => 'Person A',
            'user_id' => 1,
        ]);

        // Seed ProductLines
        $productLine = ProductLine::create([
            'name' => 'HiReach',
            'type' => 'Type 1',
            'company_id' => $company->id,
        ]);

        // Seed CommerceItems
        CommerceItem::create([
            'sku' => 'HR-DST',
            'name' => 'Item 1',
            'spec' => 'Spec 1',
            'source_id' => 1,
            'type' => 'Type A',
            'unit' => 'Unit 1',
            'description' => 'Description for Item 1',
            'general_discount' => 10.0,
            'fs_price' => 100.0,
            'unit_price' => 90.0,
            'way_import' => 'Air',
            'status' => 'Active',
            'product_line' => $productLine->id,
            'user_id' => 1,
        ]);
    }
}
