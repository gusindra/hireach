<?php

namespace Tests\Feature;

use App\Models\Request;
use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestMessageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_request_message()
    {
        $user = User::find(2);

        Request::create([
            'source_id'         => 'Testing', 
            'user_id'           => $user->id,
            'client_id'         => 'CLIENT'.$user->id,
            'from'              => 'SENDER'.$user->id,
            'type'              => 0,
            'status'            => 'SUCCESS', 
            'reply'             => 'Testing', 
        ]);

        $this->assertDatabaseHas('requests', [
            'user_id'           => $user->id, 
        ])->expectsDatabaseQueryCount( 1);

        Request::where('user_id', $user->id)->delete();
    }

    public function test_can_create_saldo_via_observer_create_request_message()
    {
        $user = User::find(2);

        $this->assertDatabaseHas('saldo_users', [
            'mutation' => 'debit',  
            'user_id' => $user->id,
        ])->expectsDatabaseQueryCount( 1);

        SaldoUser::where('user_id', $user->id)->delete();
    }
}
