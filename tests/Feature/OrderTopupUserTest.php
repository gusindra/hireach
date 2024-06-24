<?php

namespace Tests\Feature;

use App\Http\Livewire\Order\Edit;
use App\Http\Livewire\Saldo\TopupUser;
use App\Models\Billing;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\SaldoUser;
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
            ->set('nominal', '100')
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


    public function test_topup_1_auto()
    {

        $order = Order::where('total', '100')->latest()->first();
        // Get the latest saldo entry related to the order
        $saldo = SaldoUser::where('model', 'Order')->where('model_id', $order->id)->latest()->first();

        // Assert that the saldo entry was created correctly
        $this->assertDatabaseHas('saldo_users', [
            'id' => $saldo->id,
            'user_id' => $saldo->user_id,
            'amount' => 100,
            'balance' => $saldo->balance,
        ]);
    }

    public function test_create_order_and_order_products2()
    {
        $user = User::find(2);
        $this->actingAs($user);
        Livewire::actingAs($user)->test(TopupUser::class)
            ->set('nominal', '100')
            ->call('create');
        $this->assertDatabaseHas('orders', [
            'name' => 'Request Topup from ' . $user->name,
            'status' => 'unpaid',

        ]);
    }

    public function test_can_create_billing_via_observer_order2()
    {

        $order = Order::latest()->first();
        $this->assertDatabaseHas('billings', [
            'order_id' => $order->id,
        ]);
    }


    public function test_can_create_order_product_topup_via_observer_order2()
    {

        $order = Order::latest()->first();
        $orderProductTax = OrderProduct::where('name', 'Topup')->latest()->first();
        $this->assertDatabaseHas('order_products', [
            'name' => $orderProductTax->name,
            'model_id' => $order->id,
        ]);
    }

    public function test_render_order_confirm2()
    {
        $user = User::find(2);
        $order = Order::latest()->first();
        $response = $this->actingAs($user)->get('payment/invoice/' . $order->id);
        $response->assertStatus(200);
    }


    public function test_admin_change_status_to_paid2()
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
    public function test_topup_2_auto()
    {

        $order = Order::latest()->first();
        $saldo = SaldoUser::where('model', 'Order')->where('model_id', $order->id)->latest()->first();

        $this->assertDatabaseHas('saldo_users', [
            'id' => $saldo->id,
            'user_id' => $saldo->user_id,
            'amount' => 100,
            'balance' => $saldo->balance,
        ]);
    }
}
