<?php

namespace Tests\Feature;

use App\Http\Livewire\Saldo\Topup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SaldoUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_create_saldo_user()
    {

        $user = User::find(1);
        Livewire::actingAs($user)
            ->test(Topup::class, ['id' => $user->id])
            ->set('team', 1)
            ->set('currency', 'IDR')
            ->set('amount', 100)
            ->set('mutation', 'credit')
            ->set('description', 'Test top-up')
            ->call('create')
            ->assertSet('modalActionVisible', false)
            ->assertEmitted('refreshLivewireDatatable');


        $this->assertDatabaseHas('saldo_users', [
            'team_id' => 1,
            'currency' => 'IDR',
            'amount' => 100,
            'mutation' => 'credit',
            'description' => 'Test top-up',
            'user_id' => $user->id,
        ]);
    }
}
