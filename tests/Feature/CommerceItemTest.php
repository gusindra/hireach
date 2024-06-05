<?php

namespace Tests\Feature;

use App\Http\Livewire\Setting\General\CommerceItem\Add;
use App\Http\Livewire\Setting\General\CommerceItem\Edit;
use App\Models\CommerceItem;
use App\Models\Company;
use App\Models\ProductLine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommerceItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_can_create_commerce_item()
    {
        $user = User::find(1);
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'tax_id' => '123456789',
            'post_code' => '12345',
            'province' => 'Test Province',
            'city' => 'Test City',
            'address' => 'Test Address',
            'person_in_charge' => 'Test Person',
            'user_id' => $user->id
        ]);
        $productLine = ProductLine::create([
            'name' => 'Product Line',
            'company_id' => $company->id
        ]);

        Livewire::actingAs($user)
            ->test(Add::class)
            ->set('sku', 'Test SKU')
            ->set('name', 'Test Name')
            ->set('spec', 'Test Spec')
            ->set('general_discount', 50)
            ->set('fs_price', 200)
            ->set('unit_price', 300)
            ->set('product_line', $productLine->id)
            ->call('create');

        $this->assertDatabaseHas('commerce_items', [
            'sku' => 'Test SKU',
            'name' => 'Test Name',
            'spec' => 'Test Spec',
            'general_discount' => 50,
            'fs_price' => 200,
            'unit_price' => 300,
            'product_line' => $productLine->id,
            'user_id' => $user->id,
        ]);

        $company->delete();
        $productLine->delete();
    }

    public function test_can_update_commerce_item()
    {
        $user = User::find(1);
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'tax_id' => '123456789',
            'post_code' => '12345',
            'province' => 'Test Province',
            'city' => 'Test City',
            'address' => 'Test Address',
            'person_in_charge' => 'Test Person',
            'user_id' => $user->id
        ]);
        $productLine = ProductLine::create([
            'name' => 'Product Line',
            'company_id' => $company->id
        ]);
        $commerceItem = CommerceItem::create([
            'sku' => 'Test SKU',
            'name' => 'Test Name',
            'spec' => 'Test Spec',
            'source_id' => 'Test Source ID',
            'type' => 'Test Type',

            'description' => 'Test Description',
            'general_discount' => 20,
            'fs_price' => 100,
            'unit_price' => 200,
            'way_import' => 'Test Way Import',
            'status' => 'Test Status',
            'product_line' => $productLine->id,
            'user_id' => $user->id,
        ]);


        Livewire::actingAs($user)
            ->test(Edit::class, ['commerceItem' => $commerceItem])
            ->set('input.sku', 'Updated SKU')
            ->set('input.name', 'Updated Name')
            ->set('input.spec', 'Updated Spec')
            ->set('input.source_id', 'Updated Source ID')
            ->set('input.type', 'Updated Type')

            ->set('input.description', 'Updated Description')
            ->set('input.general_discount', 30)
            ->set('input.fs_price', 150)
            ->set('input.unit_price', 250)
            ->set('input.status', 'Updated Status')
            ->set('input.product_line', $productLine->id)
            ->call('update', $commerceItem->id);

        $this->assertDatabaseHas('commerce_items', [
            'id' => $commerceItem->id,
            'sku' => 'Updated SKU',
            'name' => 'Updated Name',
            'spec' => 'Updated Spec',
            'source_id' => 'Updated Source ID',
            'type' => 'Updated Type',
            'description' => 'Updated Description',
            'general_discount' => 30,
            'fs_price' => 150,
            'unit_price' => 250,
            'status' => 'Updated Status',
            'product_line' => $productLine->id,

        ]);

        $company->delete();
        $productLine->delete();
        $commerceItem->delete();
    }
    public function test_can_delete_commerce_item()
    {
        $user = User::find(1);
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'tax_id' => '123456789',
            'post_code' => '12345',
            'province' => 'Test Province',
            'city' => 'Test City',
            'address' => 'Test Address',
            'person_in_charge' => 'Test Person',
            'user_id' => $user->id
        ]);
        $productLine = ProductLine::create([
            'name' => 'Product Line',
            'company_id' => $company->id
        ]);
        $commerceItem = CommerceItem::create([
            'sku' => 'Test SKU',
            'name' => 'Test Name',
            'spec' => 'Test Spec',
            'source_id' => 'Test Source ID',
            'type' => 'Test Type',

            'description' => 'Test Description',
            'general_discount' => 20,
            'fs_price' => 100,
            'unit_price' => 200,
            'way_import' => 'Test Way Import',
            'status' => 'Test Status',
            'product_line' => $productLine->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(Edit::class, ['commerceItem' => $commerceItem])
            ->call('modalAction')
            ->call('delete');

        $this->assertDatabaseMissing('commerce_items', [
            'id' => $commerceItem->id,
        ]);
        $company->delete();
        $productLine->delete();
        $commerceItem->delete();
    }

    public function test_can_render_show_commerce_item()
    {
        $user = User::find(1);
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'tax_id' => '123456789',
            'post_code' => '12345',
            'province' => 'Test Province',
            'city' => 'Test City',
            'address' => 'Test Address',
            'person_in_charge' => 'Test Person',
            'user_id' => $user->id
        ]);
        $productLine = ProductLine::create([
            'name' => 'Product Line',
            'company_id' => $company->id
        ]);
        $commerceItem = CommerceItem::create([
            'sku' => 'Test SKU',
            'name' => 'Test Name',
            'spec' => 'Test Spec',
            'source_id' => 'Test Source ID',
            'type' => 'Test Type',

            'description' => 'Test Description',
            'general_discount' => 20,
            'fs_price' => 100,
            'unit_price' => 200,
            'way_import' => 'Test Way Import',
            'status' => 'Test Status',
            'product_line' => $productLine->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('admin/setting/commerce-item/' . $commerceItem->id);
        $response->assertStatus(200);

        $company->delete();
        $productLine->delete();
        $commerceItem->delete();
    }
}
