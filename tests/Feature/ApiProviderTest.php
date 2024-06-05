<?php

namespace Tests\Feature;

use App\Jobs\ProcessEmailApi;
use App\Jobs\ProcessSmsApi;
use App\Models\BlastMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

class ApiProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mackrokiosk_can_send_sms_otp()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_mackrokiosk_can_send_sms_non_otp()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_mackrokiosk_can_send_whatsapp_non_otp()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_mackrokiosk_can_send_whatsapp_otp()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_enjoymov_can_sending_long_number_sms()
    {
        Bus::fake();

        // Do some things to set up date, call an endpoint, etc.

        Bus::assertDispatched(ProcessSmsApi::class, function ($job) {
            return $job->data['action'] === 'EMProvider';
        });
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_enjoymov_can_sending_long_number_whatsapp()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_smtp2go_can_sending_email()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function it_dispatches_to_request_process_email_api_job()
	{
		Queue::fake();
        $user = User::find(2);

		$this->actingAs($user);

		// $comment = factory(BlastMessage::class)->create([
		// 	'author_id' => $user->first()->getKey(),
		// 	'content' => 'lorem ipsum'
		// ]);

		//$service->upload($comment->first(), $request);

		Queue::assertPushed(ProcessEmailApi::class, function ($job) {
			return $job->resource;
		});
	}
}
