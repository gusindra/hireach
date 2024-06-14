<?php

namespace Tests\Feature;

use App\Http\Livewire\Resource\AddResource;
use App\Jobs\ProcessEmailApi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TestCase;

class SendResourceUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_render_oneway()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('resources?resource=1');

        $response->assertStatus(200);
    }
    public function test_render_twoway()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('resources?resource=2');

        $response->assertStatus(200);
    }

    public function test_send_resource_by_email()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('resources?resource=2');

        $response->assertStatus(200);
    }

    public function test_it_can_send_resource_one_way_via_email()
    {


        $user = User::find(2);


        Livewire::actingAs($user)->test(AddResource::class, ['uuid' => $user->id])
            ->set('channel', 'email')
            ->set('from', 'noreply@hireach.archeeshop.com')
            ->set('to', 'imadeardanayatra0251@gmail.com')
            ->set('title', 'Test Email')
            ->set('type', 'EMAIL')
            ->set('text', 'FROM PHP ARTISAN TEST.')
            ->call('sendResource');


        $this->assertDatabaseHas('blast_messages', [
            'user_id' => $user->id,
            'msisdn' => 'imadeardanayatra0251@gmail.com',
            'status' => 'SUCCESS',
        ]);
    }

    public function test_it_can_send_resource_one_way_via_long_sms()
    {


        $user = User::find(2);


        Livewire::actingAs($user)->test(AddResource::class, ['uuid' => $user->id])
            ->set('channel', 'long_sms')
            ->set('from', '087767653663')
            ->set('to', '09090')
            ->set('title', 'SMS INI YA')
            ->set('type', 'SMS')
            ->set('text', 'FROM PHP ARTISAN TEST.')
            ->call('sendResource');


        $this->assertDatabaseHas('blast_messages', [
            'user_id' => $user->id,
            'msisdn' => '09090',
            'status' => 'SUCCESS',
        ]);
    }


    public function test_it_can_send_resource_one_way_via_sms()
    {


        $user = User::find(2);


        Livewire::actingAs($user)->test(AddResource::class, ['uuid' => $user->id])
            ->set('channel', 'sms')
            ->set('from', '087767653663')
            ->set('to', '09090')
            ->set('title', 'SMS INI YA')
            ->set('type', 'SMS')
            ->set('text', 'FROM PHP ARTISAN TEST.')
            ->call('sendResource');


        $this->assertDatabaseHas('blast_messages', [
            'user_id' => $user->id,
            'msisdn' => '09090',
            'status' => 'SUCCESS',
        ]);
    }

    public function test_it_can_send_resource_one_way_via_wa()
    {


        $user = User::find(2);


        Livewire::actingAs($user)->test(AddResource::class, ['uuid' => $user->id])
            ->set('channel', 'long_wa')
            ->set('from', '087767653663')
            ->set('to', '09090')
            ->set('title', 'SMS INI YA')
            ->set('type', 'SMS')
            ->set('text', 'FROM PHP ARTISAN TEST.')
            ->call('sendResource');


        $this->assertDatabaseHas('blast_messages', [
            'user_id' => $user->id,
            'msisdn' => '09090',
            'status' => 'SUCCESS',
        ]);
    }

    public function test_it_can_send_resource_one_way_via_sms_otp()
    {


        $user = User::find(2);


        Livewire::actingAs($user)->test(AddResource::class, ['uuid' => $user->id])
            ->set('channel', 'sms_otp')
            ->set('from', '087767653663')
            ->set('to', '09090')
            ->set('title', 'SMS  OTGPINI YA')
            ->set('type', 'SMS')
            ->set('text', 'FROM PHP ARTISAN TEST.')
            ->call('sendResource');


        $this->assertDatabaseHas('blast_messages', [
            'user_id' => $user->id,
            'msisdn' => '09090',
            'status' => 'SUCCESS',
        ]);
    }
}
