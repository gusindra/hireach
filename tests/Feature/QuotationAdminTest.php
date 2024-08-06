<?php

namespace Tests\Feature;

use App\Http\Livewire\Commercial\Quotation\Item;
use App\Models\OrderProduct;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class QuotationAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_quotation()
    {

        $user = User::find(1);
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Commercial\Quotation\Add::class)
            ->set('type', 'selling')
            ->set('title', 'New Quotation')
            ->set('date', now()->format('Y-m-d'))
            ->set('valid_day', 30)
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        // Assert that the quotation was created in the database
        $this->assertDatabaseHas('quotations', [
            'type' => 'selling',
            'title' => 'New Quotation',
            'date' => now()->format('Y-m-d'),
            'valid_day' => 30,
            'user_id' => $user->id,
        ]);
    }

    public function test_can_edit_update_information_quotation()
    {
        $user = User::find(1);
        $quotation = Quotation::where('title', 'New Quotation')->first();
        $customer = User::find(2);
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Commercial\Quotation\Edit::class, ['code' => $quotation->id])
            ->set('name', 'New Title Updated')
            ->set('quoteNo', 'Q-002')
            ->set('date', now()->format('Y-m-d'))
            ->set('valid_day', 60)
            ->set('status', 'draft')
            ->set('type', 'product')
            ->set('terms', 'New Terms')
            ->set('model', 'user')
            ->set('model_id',    $customer->id)
            ->set('addressed_company', 'New Company')
            ->set('description', 'New Description')
            ->set('created_by', $user->name)
            ->set('created_role', 'admin')
            ->set('addressed_name', 'New Addressed Name')
            ->set('addressed_role', 'New Addressed Role')
            ->call('update', $quotation->id)
            ->assertEmitted('saved');

        // Assert that the quotation was updated in the database
        $this->assertDatabaseHas('quotations', [
            'id' => $quotation->id,
            'title' => 'New Title Updated',
            'quote_no' => 'Q-002',
            'date' => now()->format('Y-m-d'),
            'valid_day' => 60,
            'status' => 'draft',
            'type' => 'selling',
            'terms' => 'New Terms',
            'model' => 'user',
            'model_id' => $customer->id,
            'addressed_company' => 'New Company',
            'description' => 'New Description',
            'created_by' => $user->name,
            'created_role' => 'admin',
            'addressed_name' => 'New Addressed Name',
            'addressed_role' => 'New Addressed Role'
        ]);
    }

    public function test_add_item()
    {
        $user = User::find(1);

        $data = Quotation::where('title', 'New Title Updated')->first();
        Livewire::actingAs($user)
            ->test(Item::class, ['data' => $data])
            ->set('name', 'Test Product')
            ->set('price', 100)
            ->set('qty', 2)
            ->set('unit', 'pcs')
            ->set('description', 'Test description')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('order_products', [
            'name' => 'Test Product',
            'price' => 100,
            'qty' => 2,
            'unit' => 'pcs',
            'note' => 'Test description',
            'user_id' => $user->id,
            'model' => 'Quotation',
            'model_id' => $data->id
        ]);
    }

    public function test_can_submit_quotation()
    {
        $user = User::find(1);
        $quotation = Quotation::where('title', 'New Title Updated')->first();
        Livewire::actingAs($user)
            ->test('commercial.progress', ['model' => 'quotation', 'id' => $quotation->id])
            ->call('submit');

        $this->assertEquals('submit', Quotation::where('id', $quotation->id)->latest()->first()->status);
    }


    public function test_can_delete_item_and_quotation()
    {

        $user = User::find(1);
        $quotation = Quotation::where('title', 'New Title Updated')->latest()->first();
        $customer = User::find(2);
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Commercial\Quotation\Edit::class, ['code' => $quotation->id])
            ->set('status', 'draft')
            ->call('update', $quotation->id)
            ->assertEmitted('saved');

        $this->assertDatabaseHas('quotations', [
            'id' => $quotation->id,
            'title' => 'New Title Updated',
            'quote_no' => 'Q-002',
            'date' => now()->format('Y-m-d'),
            'valid_day' => 60,
            'status' => 'draft',
            'type' => 'selling',
            'terms' => 'New Terms',
            'model' => 'user',
            'model_id' => $customer->id,
            'addressed_company' => 'New Company',
            'description' => 'New Description',
            'created_by' => $user->name,
            'created_role' => 'admin',
            'addressed_name' => 'New Addressed Name',
            'addressed_role' => 'New Addressed Role'
        ]);


        //Delete Item
        $item = OrderProduct::where('name', 'Test Product')->where('model', 'Quotation')->latest()->first();
        Livewire::actingAs($user)
            ->test('commercial.quotation.item', ['data' => $quotation])
            ->set('item_id', $item->id)
            ->call('delete');

        $this->assertDatabaseMissing('order_products', [
            'id' => $item->id,
        ]);

        //Delete Quotation
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Commercial\Quotation\Edit::class, ['code' => $quotation->id])
            ->call('delete');

        $this->assertDatabaseMissing('quotations', [
            'id' => $quotation->id,
        ]);
    }
}
