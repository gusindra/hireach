<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiOnewayCampaignTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_oneway_campaign()
    {
        $user = User::find(2);
        $token = $user->createToken('Test Token', ['create', 'read']);
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];

        Storage::fake('local');

        $filePath = storage_path('app/contacts/contactsample.xlsx');
        $file = new UploadedFile($filePath, 'contactsample.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);


        $request = [
            'channel' => 'long_wa',
            'type' => 0,
            'title' => 'Test Campaign',
            'text' => 'This is a test message.',
            'from' => '112121',
            'provider' => 'provider3',
            'contact' => $file,
            'is_otp' => 0
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'accept' => 'application/json',
            'Content-Type' => 'multipart/form-data',
        ];

        $response = $this->actingAs($user, 'api')->post('/api/one-way/group', $request, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'code',
            'campaign_id',
            'message',
        ]);


        $this->assertDatabaseHas('campaigns', [
            'title' => 'Test Campaign',
            'channel' => 'long_wa',
            'provider' => 'provider3',
            'text' => 'This is a test message.',
        ]);
    }
}
