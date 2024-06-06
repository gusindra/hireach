<?php

namespace Tests\Feature;

use App\Http\Livewire\Order\Edit;
use App\Http\Livewire\Saldo\TopupUser;
use App\Models\Billing;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class OrderTopupUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_form_top_up()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('payment/topup');

        $response->assertStatus(200);
    }


    public function test_create_order_and_order_products()
    {
        $user = User::find(2);
        $this->actingAs($user);
        Livewire::actingAs($user)->test(TopupUser::class)
            ->set('nominal', '440000')
            ->call('create');
        $this->assertDatabaseHas('orders', [
            'name' => 'Request Topup from ' . $user->name,
            'status' => 'unpaid',

        ]);
    }

    public function test_can_create_billing_via_observer_order()
    {

        $order = Order::latest()->first();
        $this->assertDatabaseHas('billings', [
            'order_id' => $order->id,
        ]);
    }

    public function test_can_create_order_product_TAX_via_observer_order()
    {

        $order = Order::latest()->first();
        $orderProductTax = OrderProduct::where('name', 'Tax')->latest()->first();
        $this->assertDatabaseHas('order_products', [
            'name' => $orderProductTax->name,
            'model_id' => $order->id,
        ]);
    }

    public function test_can_create_order_product_topup_via_observer_order()
    {

        $order = Order::latest()->first();
        $orderProductTax = OrderProduct::where('name', 'Topup')->latest()->first();
        $this->assertDatabaseHas('order_products', [
            'name' => $orderProductTax->name,
            'model_id' => $order->id,
        ]);
    }

    public function test_render_order_confirm()
    {
        $user = User::find(2);
        $order = Order::latest()->first();
        $response = $this->actingAs($user)->get('payment/invoice/' . $order->id);
        $response->assertStatus(200);
    }


    public function test_admin_change_status_to_paid()
    {
        $user = User::find(1);
        $order = Order::latest()->first();

        Livewire::actingAs($user)
            ->test(Edit::class, ['uuid' => $order->id])
            ->set('input.status', 'paid')
            ->call('update', $order->id)
            ->assertEmitted('saved');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',

        ]);
    }
}
