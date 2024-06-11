<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Illuminate\Support\Str;

class ApiDocumentationTest extends TestCase
{
    public $token;
    public $idToken;
    public $plainTextToken;
    /**
     * A test feature for test render api documentation.
     *
     * @return void
     */
    public function api_documentation_screen_can_be_rendered()
    {
        $response = $this->get('/api/documentation');
        $response->assertStatus(200);
    }

    /**
     * test_api_token_permissions_can_be_created
     *
     * @return void
     */
    public function api_token_permissions_can_be_created()
    {
        $name = Str::random(10);
        $user = User::find(2);
        $user->tokens()->create([
            'name' => $name,
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => $name,
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
        ]);
        $this->assertTrue($user->fresh()->tokens->first()->can('create'));
        $this->assertTrue($user->fresh()->tokens->first()->can('read'));
        $this->assertFalse($user->fresh()->tokens->first()->can('delete'));
    }

    /**
     * A post test feature for test render api documentation.
     *
     * @return void
     */
    public function api_one_way_can_be_posted()
    {
        $user = User::find(2);
        $token = $user->createToken(
            'Test Token',
            ['create', 'read']
        );
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];
        $newData = [
            "channel" => "email",
            "type" => 0,
            "title" => "New Product Launch",
            "text" => "Hi Dev, your account has been updated.",
            "templateid" => 1,
            "to" => "string",
            "from" => "string",
            "provider" => "string",
            "otp" => 0,
        ];
        $newHeader = [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-CSRF-TOKEN' => '',
        ];

        $response = $this->actingAs($user, 'api')->post('/api/one-way', $newData, $newHeader);

        $response->assertStatus(200);
    }

    /**
     * A post test feature for test render api documentation.
     *
     * @return void
     */
    public function api_one_way_can_be_access_get_method()
    {
        $user = User::find(2);
        $token = $user->createToken(
            'Test Token',
            ['create', 'read']
        );
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];
        $response = $this->actingAs($user, 'api')->get('/api/one-way?page=0&pageSize=10', [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-CSRF-TOKEN' => '',
        ]);

        $response->assertStatus(200);
    }

    /**
     * A post test feature for test render api documentation.
     *
     * @return void
     */
    // public function test_api_two_way_can_be_posted()
    // {
    //     $user = User::find(2);
    //     $token = $user->createToken(
    //         'Test Token',
    //         ['create', 'read']
    //     );
    //     $plainTextToken = explode('|', $token->plainTextToken, 2)[1];
    //     $response = $this->actingAs($user, 'api')->post('/api/two-way', [
    //         "channel" => "web",
    //         "type" => 0,
    //         "title" => "New Product Launch",
    //         "text" => "Hi, {client_name}, your account has been updated with the following features in March. Find out more on our website!",
    //         "templateid" => 1,
    //         "to" => "string",
    //         "from" => "string",
    //         "provider" => "string"
    //     ],[
    //         'Authorization'=>'Bearer '.$plainTextToken,
    //         'accept'=>'application/json',
    //         'Content-Type'=>'application/json',
    //         'X-CSRF-TOKEN'=>'',
    //     ]);

    //     $response->assertStatus(200);
    // }

    /**
     * A post test feature for test render api documentation.
     *
     * @return void
     */
    public function api_two_way_can_be_access_get_method()
    {
        $user = User::find(2);
        $token = $user->createToken(
            'Test Token',
            ['create', 'read']
        );
        $plainTextToken = explode('|', $token->plainTextToken, 2)[1];

        $response = $this->actingAs($user, 'api')->get('/api/two-way?page=0&pageSize=10', [
            'Authorization' => 'Bearer ' . $plainTextToken,
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-CSRF-TOKEN' => '',
        ]);

        $response->assertStatus(200);
    }

    /**
     * A post test feature for test render api documentation.
     *
     * @return void
     */
    public function api_token_permissions_can_be_deleted()
    {
        $user = User::find(2);
        $token = $user->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);
        $idToken = explode('|', $token->plainTextToken, 2)[0];

        $user->tokens()->where('tokenable_type', 'App\Models\User')->where('tokenable_id', '2')->delete();

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $idToken]);
    }
}
