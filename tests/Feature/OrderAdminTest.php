<?php

namespace Tests\Feature;

use App\Http\Livewire\Order\Edit;
use App\Http\Livewire\Order\Item;
use App\Http\Livewire\Order\OrderProgress;
use App\Models\Commision;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OrderAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_order()
    {
        $user = User::find(1);

        Livewire::actingAs($user)
            ->test('order.add')
            ->set('name', 'Sample Order')
            ->set('type', 'selling')
            ->set('entity', 'Sample Entity')
            ->set('customer_id', $user->id)
            ->set('model', 'Sample Source')
            ->set('source', 45)
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable')
            ->assertSet('modalActionVisible', false);

        $this->assertDatabaseHas('orders', [
            'name' => 'Sample Order',
            'type' => 'selling',
            'entity_party' => 'Sample Entity',
            'status' => 'draft',
            'customer_id' => $user->id,
            'user_id' => $user->id,
            'source' => 'Sample Source',
            'source_id' => 45,
        ]);
    }


    public function test_can_update_edit_component()
    {

        $user = User::find(1);
        $order = Order::where('name', 'Sample Order')->first();
        $customer = User::find(2);
        $newDate = now()->addDays(7)->format('Y-m-d');


        Livewire::actingAs($user)
            ->test(Edit::class, ['uuid' => $order->id])
            ->set('input.name', 'Updated Order Name')
            ->set('input.status', 'draft')
            ->set('input.customer_id', $customer->id)
            ->set('input.date', $newDate)
            ->call('update', $order->id)
            ->assertEmitted('saved');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'name' => 'Updated Order Name',
            'status' => 'draft',
            'customer_id' => $customer->id,
            'date' => $newDate,
        ]);

        // Add Item
        Livewire::actingAs($user)
            ->test(Item::class, ['data' => $order])
            ->set('name', 'Topup')
            ->set('price', 100)
            ->set('qty', 2)
            ->set('unit', 'pcs')
            ->set('description', 'Test Description')
            ->call('create')
            ->assertEmitted('added');



        $this->assertDatabaseHas('order_products', [
            'name' => 'Topup',
            'price' => 100,
            'qty' => 2,
            'unit' => 'pcs',
            'note' => 'Test Description',
            'user_id' => $user->id,
            'model_id' => $order->id,

        ]);

        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Order\Item::class, ['data' => $order])
            ->set('tax', 89)
            ->call('updateTax');
        $updatedOrder = Order::find($order->id);

        $this->assertEquals(89, $updatedOrder->vat);

        Livewire::test(OrderProgress::class, ['id' => $order->id])
            ->call('update');

        // Assert that the order status has been updated to 'unpaid'
        $this->assertEquals('unpaid', Order::find($order->id)->status);


        $orderProduct = OrderProduct::where('name', 'Topup')->first();
        //Delete Item
        Livewire::actingAs($user)
            ->test('order.item', ['data' => $order])
            ->call('deleteShowModal', $orderProduct->id)
            ->call('delete')
            ->assertDispatchedBrowserEvent('event-notification');

        $this->assertDatabaseMissing('order_products', [
            'id' => $orderProduct->id,
        ]);

        //End Item
    }



    public function test_can_updatecommission_agent()
    {
        $user = User::find(1);
        $client = User::find(2);
        $order = Order::where('name', 'Updated Order Name')->latest()->first();



        $commision = Commision::create([
            'model' => 'order',
            'model_id' => $order->id,
            'rate' => 10,
            'status' => 'active',
            'client_id' => $client->id,
        ]);




        // Update the commission
        Livewire::test('commission.edit', ['model' => 'order', 'data' => $order, 'disabled' => false])
            ->set('rate', 10)
            ->set('clientId', $client->id)
            ->set('type', 'percentage')
            ->call('update', $order->id);

        $this->assertDatabaseHas('commisions', [
            'id' => $commision->id,
            'ratio' => 10,
            'type' => 'percentage',
            'client_id' => $client->id,
        ]);
    }

    public function test_can_delete_commisions()
    {
        $user = User::find(1);
        $client = User::find(2);
        $order = Order::latest()->first();
        $commision = Commision::where('model_id', $order->id)->latest()->first();
        Livewire::actingAs($user)
            ->test(\App\Http\Livewire\Commission\Edit::class, ['model' => 'order', 'data' => $order, 'disabled' => false])
            ->call('removeAgent', $commision->id);

        $this->assertDatabaseMissing('commisions', [
            'id' => $commision->id,
        ]);
    }


    public function test_can_delete_order()
    {

        $user = User::find(1);
        $order = Order::where('name', 'Updated Order Name')->first();

        Livewire::actingAs($user)
            ->test(Edit::class, ['uuid' => $order->id])
            ->call('delete');


        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }
}
