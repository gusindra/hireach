<?php

namespace Tests\Feature;

use App\Models\BlastMessage;
use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class BlastMessageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */ 

    public function test_can_create_blast_message()
    {
        $user = User::find(2);

        BlastMessage::create([
            'title'             => 'Testing',
            'msg_id'            => 'TESTING'.$user->id,
            'user_id'           => $user->id,
            'client_id'         => 'CLIENT'.$user->id,
            'sender_id'         => 'SENDER'.$user->id,
            'type'              => 0,
            'status'            => 'SUCCESS',
            'code'              => '200',
            'message_content'   => 'Testing',
            'balance'           => 0,
            'msisdn'            => 'msisdn'.$user->id,
        ]);

        $this->assertDatabaseHas('blast_messages', [
            'title'             => 'Testing', 
            'user_id'           => $user->id, 
        ])->expectsDatabaseQueryCount( 1);

        BlastMessage::where('user_id', $user->id)->delete();
    }

    public function test_can_create_saldo_via_observer_create_blast_message()
    {
        $user = User::find(2);

        $this->assertDatabaseHas('saldo_users', [
            'mutation' => 'debit',  
            'user_id' => $user->id,
        ])->expectsDatabaseQueryCount( 1);

        SaldoUser::where('user_id', $user->id)->delete();
    }
}
