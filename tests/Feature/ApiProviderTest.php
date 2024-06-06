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
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('SMS is OK')
            ->doesntExpectOutput('SMS is ERROR')
            ->assertExitCode(0);
    }

    public function test_mackrokiosk_can_send_sms_non_otp()
    {
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('SMS is OK')
            ->doesntExpectOutput('SMS is ERROR')
            ->assertExitCode(0);
    }

    public function test_mackrokiosk_can_send_whatsapp_non_otp()
    {
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('WA is OK')
            ->doesntExpectOutput('WA is ERROR')
            ->assertExitCode(0);
    }

    public function test_mackrokiosk_can_send_whatsapp_otp()
    {
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('WA is OK')
            ->doesntExpectOutput('WA is ERROR')
            ->assertExitCode(0);
    }

    public function test_enjoymov_can_sending_long_number_sms()
    {
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('SMS is OK')
            ->doesntExpectOutput('SMS is ERROR')
            ->assertExitCode(0);
    }

    public function test_enjoymov_can_sending_long_number_whatsapp()
    {
        $this->artisan('check:wa enjoymov')
            ->expectsOutput('WA is OK')
            ->doesntExpectOutput('WA is ERROR')
            ->assertExitCode(0);
    }

    public function test_smtp2go_can_sending_email()
    { 
        $this->artisan('check:email smtp2go')
            ->expectsOutput('EMAIL is OK')
            ->doesntExpectOutput('EMAIL is ERROR')
            ->assertExitCode(0);
    }

    public function it_dispatches_to_request_process_email_api_job()
	{ 
        $this->artisan('check:email email')
            ->expectsOutput('EMAIL is OK')
            ->doesntExpectOutput('EMAIL is ERROR')
            ->assertExitCode(0);
	}

    public function test_console_command()
    {
        $this->artisan('check:user 1')->assertExitCode(0);
    }
}
