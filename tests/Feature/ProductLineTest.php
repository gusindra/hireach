<?php

namespace Tests\Feature;

use App\Http\Livewire\Setting\General\ProductLine\Add;
use App\Http\Livewire\Setting\General\ProductLine\Edit;
use App\Models\Company;
use App\Models\ProductLine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductLineTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_productline_index()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('admin/settings/company');
        $response->assertStatus(200);
    }

    public function test_can_create_product_line()
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


        Livewire::actingAs($user)->test(Add::class)
            ->set('name', 'Product Line Name')
            ->set('company_id', $company->id)
            ->call('create');


        $this->assertDatabaseHas('product_lines', [
            'name' => 'Product Line Name',
            'company_id' => $company->id,
        ]);

        $company->delete();
    }

    public function test_render_productline_show()
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

        $response = $this->actingAs($user)->get('admin/setting/product-line/' . $productLine->id);
        $response->assertStatus(200);
        $company->delete();
        $productLine->delete();
    }


    public function test_can_update_product_line()
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

        Livewire::actingAs($user)->test(Edit::class, ['productLine' => $productLine])
            ->set('input.name', 'Updated Product Line Name')
            ->set('input.type', 'Updated Type')
            ->set('input.company_id', $company->id)
            ->call('updateProductLine', $productLine->id);

        $this->assertDatabaseHas('product_lines', [
            'id' => $productLine->id,
            'name' => 'Updated Product Line Name',
            'type' => 'Updated Type',
            'company_id' => $company->id,
        ]);

        $company->delete();
        $productLine->delete();
    }

    public function test_can_delete_product_line()
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


        Livewire::actingAs($user)->test(Edit::class, ['productLine' => $productLine])
            ->call('delete');
        $this->assertDatabaseMissing('product_lines', ['id' => $productLine->id]);
    }
}
