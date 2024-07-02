<?php

namespace Tests\Feature;

use App\Http\Livewire\Chat\ChatSlug;
use App\Http\Livewire\Template\AddAction;
use App\Http\Livewire\Template\AddError;
use App\Http\Livewire\Template\EditAnswer;
use App\Http\Livewire\Template\EditTemplate;
use App\Http\Livewire\Template\EditTrigger;
use App\Http\Livewire\Template\TwoWay;
use App\Models\Action;
use App\Models\Client;
use App\Models\DataAction;
use App\Models\Endpoint;
use App\Models\Request;
use App\Models\Team;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;


class TemplateChatTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(2);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_begin_form_chat_can_be_rendered()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('chating/User');

        $response->assertStatus(200);
    }

    public function test_can_create_all_resource_templates()
    {
        $this->actingAs($this->user);

        $templateData = [
            ['Template Welcome', 'welcome', 'Example Description'],
            ['Template Message', 'text', 'Example Description'],
            ['Template Question', 'question', 'Example Description'],
            ['Template Api', 'api', 'Descript Apiion'],
        ];

        foreach ($templateData as [$name, $type, $description]) {
            Livewire::test(TwoWay::class)
                ->set('name', $name)
                ->set('type', $type)
                ->set('description', $description)
                ->call('create')
                ->assertEmitted('refreshLivewireDatatable');

            $this->assertDatabaseHas('templates', [
                'name'        => $name,
                'type'        => $type,
                'description' => $description,
            ]);
        }
    }


    public function test_can_create_condition_for_templates()
    {
        $this->actingAs($this->user);

        $templateData = [
            ['Template Message', 100],
            ['Template Question', 500],
            ['Template Api', 300],

        ];

        foreach ($templateData as [$name, $triggerValue]) {
            $template = Template::where('name', $name)->latest()->firstOrFail();

            Livewire::test(EditTrigger::class, ['template' => $template])
                ->assertStatus(200)
                ->set('trigger', $triggerValue)
                ->set('trigger_condition', 'equals')
                ->call('updateTrigger');

            $this->assertDatabaseHas('templates', [
                'id' => $template->id,
                'trigger' => $triggerValue,
                'trigger_condition' => 'equals',
            ]);
        }
    }

    public function test_can_createaction()
    {

        $this->actingAs($this->user);


        $templateData = [
            ['Template Message', 'text', 'Message'],
            ['Template Question', 'text', 'Question'],
            ['Template Api', 'text', 'Api'],
            ['Template Welcome', 'text', 'Welcome'],
        ];

        foreach ($templateData as [$name, $type, $for]) {

            $template = Template::where('name', $name)->latest()->firstOrFail();


            Livewire::test(AddAction::class, ['template' => $template])
                ->assertStatus(200)
                ->set('message', "Test action for $for")
                ->set('type', $type)
                ->call('create')
                ->assertHasNoErrors();


            $this->assertDatabaseHas('actions', [
                'message' => "Test action for $for",
                'type' => $type,
            ]);
        }
    }

    public function test_it_checks_client_and_creates_new_if_not_exists()
    {
        $this->actingAs($this->user);
        $team = Team::find(2);
        $component = Livewire::test(ChatSlug::class, ['team' => $team]);

        $component->set('name', 'Chat Test');
        $component->set('number', '555');

        $component->call('checkClient');

        $this->assertTrue(Client::where('phone', '555')->exists());
    }

    public function test_it_sends_a_message_wellome()
    {
        $this->actingAs($this->user);
        $team = Team::find(2);
        $client = Client::latest()->first();


        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', 'Hello World')
            ->call('sendMessage')
            ->assertSet('message', null);

        $this->assertTrue(Request::where('reply', 'Test action for Welcome')->exists());
    }

    public function test_it_sends_a_message_text()
    {
        $this->actingAs($this->user);
        $team = Team::find(2);
        $client = Client::latest()->first();


        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '100')
            ->call('sendMessage')
            ->assertSet('message', null);

        $this->assertTrue(Request::where('reply', 'Test action for Message')->exists());
    }

    public function test_it_sends_a_message_question()
    {
        $this->actingAs($this->user);
        $team = Team::find(2);
        $client = Client::latest()->first();
        $template = Template::where('name', 'Template Question')->latest()->first();
        Livewire::test(EditAnswer::class, ['template' => $template])
            ->set('type', 'text')
            ->set('name', 'For Test Question 1')
            ->set('description', 'Example Description')
            ->set('trigger', '88')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('templates', [
            'name' => 'For Test Question 1',
            'description' => 'Example Description',
            'trigger' => '88',
            'type' => 'text',
            'template_id' => $template->id,
            'user_id' => $this->user->id,
        ]);

        $templateq = Template::latest()->first();
        Livewire::test(AddAction::class, ['template' => $templateq])
            ->assertStatus(200)
            ->set('message', "Test action for Question oke")
            ->set('type', 'text')
            ->call('create')
            ->assertHasNoErrors();

        Livewire::test(AddError::class, ['template' => $template])
            ->set('type', 'error')
            ->set('name', 'Example Error Template')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('added');
        $templatew = Template::where('type', 'error')->latest()->first();
        Livewire::test(AddAction::class, ['template' => $templatew])
            ->assertStatus(200)
            ->set('message', "Test action for Question Erorrr")
            ->set('type', 'text')
            ->call('create')
            ->assertHasNoErrors();

        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '500')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for Question')->exists());

        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '88')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for Question oke')->exists());

        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '500')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for Question')->exists());

        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', 'wew')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for Question Erorrr')->exists());
    }

    public function test_it_sends_a_message_api()
    {
        $this->actingAs($this->user);
        $team = Team::find(2);
        $client = Client::latest()->first();
        $template = Template::where('name', 'Template Api')->latest()->first();
        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '300')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for Api')->exists());
        Livewire::test('template.edit-api', ['template' => $template])
            ->set('endpoint', 'http://hireach.test/api/dummy-array2')
            ->set('request', '{"code": 200}')
            ->call('create')
            ->assertEmitted('saved');

        $this->assertDatabaseHas('endpoints', [
            'endpoint' => 'http://hireach.test/api/dummy-array2',
            'request' => '{"code": 200}',
            'template_id' => $template->id,
        ]);
        $endpoint = Endpoint::latest()->first();

        Livewire::test('template.add-input', ['endpoint' => $endpoint])
            ->set('name', 'phone')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('inputs', [
            'name' => 'phone',
            'endpoint_id' => $endpoint->id,
        ]);


        Livewire::test(AddError::class, ['template' => $template])
            ->set('type', 'error')
            ->set('name', 'Example Error Template  API')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('added');

        $template1 = Template::where('type', 'error')->latest()->first();
        Livewire::test(AddAction::class, ['template' => $template1])
            ->assertStatus(200)
            ->set('message', "Test action for API Erorrr")
            ->set('type', 'text')
            ->call('create')
            ->assertHasNoErrors();

        Livewire::test('template.add-respond-api', ['template' => $template])
            ->set('type', 'text')
            ->set('name', 'Success Msg')
            ->set('description', 'Test Description')
            ->set('trigger', '200')
            ->call('create')
            ->assertEmitted('added');

        $this->assertDatabaseHas('templates', [
            'type' => 'text',
            'name' => 'Success Msg',
            'description' => 'Test Description',
            'trigger' => '200',
            'template_id' => $template->id,
            'user_id' => $this->user->id,
        ]);
        $templates = Template::where('name', 'Success Msg')->latest()->first();
        Livewire::test(AddAction::class, ['template' => $templates])
            ->assertStatus(200)
            ->set('message', "Test action for API SUcess Message , The Status is {message}")
            ->set('type', 'text')
            ->call('create')
            ->assertHasNoErrors();


        $action = Action::where('message', 'Test action for API Sucess Message , The Status is {message}')->latest()->first();

        Livewire::test('template.add-data-action', ['actionId' => $action->id])
            ->set('name', 'message')
            ->set('value', 'message')
            ->call('create');

        $dataAction = DataAction::where('action_id', $action->id)->latest()->first();

        $this->assertNotNull($dataAction);
        $this->assertEquals('message', $dataAction->name);
        $this->assertEquals('message', $dataAction->value);



        Livewire::test('App\Http\Livewire\Chat\ChatSlug', ['team' => $team])
            ->set('name', $client->name)
            ->set('number', $client->phone)
            ->call('checkClient')
            ->set('message', '1234567890')
            ->call('sendMessage')
            ->assertSet('message', null);
        $this->assertTrue(Request::where('reply', 'Test action for API Sucess Message , The Status is Success')->exists());
    }

    public function test_it_agent_can_join_a_chat()
    {
        $user = User::find(2);
        $client = Client::latest()->first();

        Livewire::actingAs($user)
            ->test('chat-box', ['client_id' => $client->id])
            ->call('joinChat');

        $this->assertDatabaseHas('handling_sessions', [
            'client_id' => $client->id,
            'agent_id' => $user->id,
            'user_id' => $user->currentTeam->user_id,
        ]);
    }

    public function test_agent_can_send_a_message()
    {
        $user = User::find(2);
        $client = Client::latest()->first();

        Livewire::actingAs($user)
            ->test('chat-box', ['client_id' => $client->id])
            ->set('message', 'Test message')
            ->call('sendMessage')
            ->assertSet('message', null);

        $this->assertDatabaseHas('requests', [
            'reply' => 'Test message',
            'from' => $user->id,
            'client_id' => $client->uuid,
            'user_id' => $user->currentTeam->user_id,
            'type' => 'text',
        ]);
    }
}
