<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiResourceValidationContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_api_skiptrace()
    {
        // Create a user and generate a token for API authentication
        $user = User::find(2);
        $token = $user->createToken('Test Token', ['create', 'read']);
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];


        Storage::fake('local');

        $filePath = storage_path('app/datawiz/ktp-sample.xlsx');
        $file = new UploadedFile($filePath, 'ktp-sample.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);


        $request = [
            'contact' => $file,
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data',
        ];

        $response = $this->actingAs($user, 'api')->post('/api/resources/skiptrace', $request, $headers);
        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'File uploaded and processing started',
        ]);

        $this->assertDatabaseHas('contacts', [
            'type' => 'skip_trace',
            'no_ktp' => '51910910010901910',
        ]);

        $this->assertDatabaseHas('client_validations', [
            'user_id' => $user->id,

        ]);
    }


    public function test_api_validation()
    {
         $user = User::find(2);
        $token = $user->createToken('Test Token', ['create', 'read']);
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];


        Storage::fake('local');

        $filePath = storage_path('app/datawiz/contact-sample.xlsx');
        $file = new UploadedFile($filePath, 'validation-sample.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

          $request = [
            'file' => $file,
            'type' => 'cellular_no',
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data',
        ];

        $response = $this->actingAs($user, 'api')->post('/api/resources/validation', $request, $headers);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Validation started.',
        ]);



        $this->assertDatabaseHas('contacts', [
            'type' => 'cellular_no',
        ]);

        $contact = Contact::where('type', 'cellular_no')->first();

        $this->assertDatabaseHas('client_validations', [
            'contact_id' => $contact->id,
            'user_id' => $user->id,
        ]);
    }
}
