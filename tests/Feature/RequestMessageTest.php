<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ProductLine;
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

        $company = Company::factory()->create();
        ProductLine::create([
            'name' => 'HiReach',
            'type' => 'for testing',
            'company_id' => $company->id
        ]);


        Request::create([
            'source_id'         => 'Testing',
            'user_id'           => $user->id,
            'client_id'         => 'CLIENT' . $user->id,
            'from'              => 'SENDER' . $user->id,
            'type'              => 0,
            'status'            => 'SUCCESS',
            'reply'             => 'Testing',
        ]);

        $this->assertDatabaseHas('requests', [
            'user_id'           => $user->id,
        ])->expectsDatabaseQueryCount(1);

        Request::where('user_id', $user->id)->delete();
    }

    public function test_can_create_saldo_via_observer_create_request_message()
    {
        $user = User::find(2);

        $this->assertDatabaseHas('saldo_users', [
            'mutation' => 'debit',
            'user_id' => $user->id,
        ])->expectsDatabaseQueryCount(1);

        SaldoUser::where('user_id', $user->id)->delete();
    }
}
