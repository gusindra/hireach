<?php

namespace Tests\Feature;

use App\Http\Livewire\Template\AddAction;
use App\Http\Livewire\Template\AddDataAction;
use App\Http\Livewire\Template\AddError;
use App\Http\Livewire\Template\AddInput;
use App\Http\Livewire\Template\AddRespondApi;
use App\Http\Livewire\Template\Delete;
use App\Http\Livewire\Template\EditApi;
use App\Http\Livewire\Template\EditTemplate;
use App\Http\Livewire\Template\EditTrigger;
use App\Http\Livewire\Template\OneWay;
use App\Http\Livewire\Template\TwoWay;
use App\Models\Action;
use App\Models\Endpoint;
use App\Models\Input;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TemplateTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(2); // Or User::find(2) if you have a specific user in mind
    }

    public function test_can_create_and_update_template_one_way()
    {
        $this->actingAs($this->user);

        // For Create
        Livewire::test(OneWay::class)
            ->set('name', 'Example Template')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        $this->assertDatabaseHas('templates', [
            'name' => 'Example Template',
            'description' => 'Example Description',
        ]);

        // For Edit
        $template = Template::where('name', 'Example Template')->firstOrFail();
        Livewire::test(EditTemplate::class, ['uuid' => $template->uuid])
            ->set('name', 'Updated Template')
            ->set('description', 'Updated Description')
            ->call('updateTemplate')
            ->assertEmitted('saved');

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => 'Updated Template',
            'description' => 'Updated Description',
        ]);
    }

    public function test_delete_template_one_way()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Updated Template')->firstOrFail();
        Livewire::test(Delete::class)
            ->call('confirmDelete', $template->id)
            ->call('delete');

        $this->assertSoftDeleted('templates', ['id' => $template->id]);
    }

    public function test_can_create_and_update_template_two_way()
    {
        $this->actingAs($this->user);

        // For Create
        Livewire::test(TwoWay::class)
            ->set('name', 'Example Template')
            ->set('type', 'api')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        $this->assertDatabaseHas('templates', [
            'name' => 'Example Template',
            'description' => 'Example Description',
            'type' => 'api'
        ]);

        // For Edit
        $template = Template::where('name', 'Example Template')->firstOrFail();
        Livewire::test(EditTemplate::class, ['uuid' => $template->uuid])
            ->set('name', 'Updated Template 2')
            ->set('description', 'Updated Description')
            ->call('updateTemplate')
            ->assertEmitted('saved');

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => 'Updated Template 2',
            'description' => 'Updated Description',
        ]);
    }

    public function test_delete_template_two_way()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Updated Template 2')->firstOrFail();
        Livewire::test(Delete::class)
            ->call('confirmDelete', $template->id)
            ->call('delete');

        $this->assertSoftDeleted('templates', ['id' => $template->id]);
    }

    public function test_can_create_and_update_endpoint()
    {
        $this->actingAs($this->user);

        // Test creation of a template
        Livewire::test(TwoWay::class)
            ->set('name', 'Example API Integration')
            ->set('type', 'api')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        $this->assertDatabaseHas('templates', [
            'name' => 'Example API Integration',
            'description' => 'Example Description',
            'type' => 'api'
        ]);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();

        // Test creation of an endpoint associated with the template
        Livewire::test(EditApi::class, ['template' => $template])
            ->set('request', 'get')
            ->set('endpoint', 'https://google.com')
            ->set('templateId', $template->id)
            ->call('create')
            ->assertStatus(200);

        $this->assertDatabaseHas('endpoints', [
            'request' => 'get',
            'endpoint' => 'https://google.com',
            'template_id' => $template->id,
        ]);

        // Test updating the endpoint associated with the template
        Livewire::test(EditApi::class, ['template' => $template])
            ->set('request', 'post')
            ->set('endpoint', 'https://google.com')
            ->set('templateId', $template->id)
            ->call('update', $template->id)
            ->assertStatus(200);

        $this->assertDatabaseHas('endpoints', [
            'template_id' => $template->id,
            'request' => 'post',
            'endpoint' => 'https://google.com',
        ]);
    }

    public function test_can_create_api_response()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();
        Livewire::test(AddRespondApi::class, ['template' => $template])
            ->assertStatus(200)
            ->set('type', 'text')
            ->set('name', 'Test Input Add Respon API')
            ->set('description', 'test Desc')
            ->set('trigger', 1)
            ->set('templateId', $template->id)
            ->call('create', $template->id);
    }

    public function test_can_create_condition()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();
        Livewire::test(EditTrigger::class, ['template' => $template])
            ->assertStatus(200)
            ->set('trigger', 1)
            ->set('trigger_condition', 'equals')
            ->call('updateTrigger');

        $this->assertDatabaseHas('templates', [
            'trigger' => 1,
            'trigger_condition' => 'equals',
        ]);
    }

    public function test_can_create_and_update_action()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();

        // Create Action
        Livewire::test(AddAction::class, ['template' => $template])
            ->assertStatus(200)
            ->set('message', 'this test action')
            ->set('type', 'text')
            ->call('create');

        $action = Action::where('template_id', $template->id)->where('message', 'this test action')->latest()->firstOrFail();

        // Update Action
        Livewire::test(AddAction::class, ['template' => $template])
            ->assertStatus(200)
            ->set('actionId', $action->id)
            ->set('message', 'this test action Update')
            ->set('type', 'text')
            ->call('update', $template->id);

        $this->assertDatabaseHas('actions', [
            'id' => $action->id,
            'message' => 'this test action Update',
            'type' => 'text',
        ]);
    }

    public function test_can_create_action_error()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();
        Livewire::test(AddError::class, ['template' => $template])
            ->assertStatus(200)
            ->set('type', 'text')
            ->set('templateId', $template->id)
            ->set('name', 'Error Test')
            ->set('description', 'description error test')
            ->call('create');

        $this->assertDatabaseHas('templates', [
            'name' => 'Error Test',
            'description' => 'description error test',

        ]);
    }

    public function test_can_create_and_update_input_at_integration()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Example API Integration')->latest()->firstOrFail();
        $endpoint = Endpoint::where('template_id', $template->id)->latest()->first();

        // Create Input
        Livewire::test(AddInput::class, ['endpoint' => $endpoint])
            ->assertStatus(200)
            ->set('name', 'test Input at integration')
            ->call('create');

        $input = Input::latest()->firstOrFail();

        // Update Input
        Livewire::test(AddInput::class, ['endpoint' => $endpoint])
            ->assertStatus(200)
            ->set('input_id', $input->id)
            ->set('name', 'test Input at integration Updated')
            ->call('update');

        $this->assertDatabaseHas('inputs', [
            'id' => $input->id,
            'name' => 'test Input at integration Updated',
        ]);
    }

    public function test_can_create_and_update_action_variable()
    {
        $this->actingAs($this->user);

        $template = Template::where('name', 'Test Input Add Respon API')->latest()->firstOrFail();

        // Create Action
        Livewire::test(AddAction::class, ['template' => $template])
            ->assertStatus(200)
            ->set('message', 'this test action 1')
            ->set('type', 'text')
            ->call('create');

        $action = Action::where('message', 'this test action 1')->latest()->firstOrFail();

        // Add Action Variable
        Livewire::test(AddDataAction::class, ['actionId' => $action->id, 'template' => $template])
            ->set('name', '$name')
            ->set('value', '[result][order][name]')
            ->call('create');

        $this->assertDatabaseHas('data_actions', [
            'action_id' => $action->id,
            'name' => '$name',
            'value' => '[result][order][name]',
        ]);
    }

    public function test_delete_all_test_data()
    {
        $this->actingAs($this->user);

        Action::truncate();
        Input::truncate();
        Endpoint::truncate();
        Template::truncate();

        $this->assertDatabaseCount('actions', 0);
        $this->assertDatabaseCount('inputs', 0);
        $this->assertDatabaseCount('endpoints', 0);
        $this->assertDatabaseCount('templates', 0);
    }
}
