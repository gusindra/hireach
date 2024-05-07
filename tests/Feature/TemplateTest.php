<?php

namespace Tests\Feature;

use App\Http\Livewire\Template\Delete;
use App\Http\Livewire\Template\EditTemplate;
use App\Http\Livewire\Template\OneWay;
use App\Http\Livewire\Template\TwoWay;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TemplateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_and_update_template_one_way()
    {
        //For Create
        $user = User::find(2);
        Livewire::actingAs($user)
            ->test(OneWay::class)
            ->set('name', 'Example Template')
            ->set('description', 'Example Description')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        $this->assertDatabaseHas('templates', [
            'name' => 'Example Template',
            'description' => 'Example Description',
        ]);

        //For Edit
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

    public function test_delete_template_oneway()
    {
        $user = User::find(2);
        $template = Template::where('name', 'Updated Template')->firstOrFail();

        Livewire::actingAs($user)
            ->test('template.delete')
            ->call('confirmDelete', $template->id)
            ->call('delete');

        $this->assertDatabaseMissing('audience', ['id' => $template->id]);
    }


    public function test_can_create_template_two_way()
    {
        //For Create
        $user = User::find(2);
        Livewire::actingAs($user)
            ->test(TwoWay::class)
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

        //For Edit
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
    public function test_delete_template_twoway()
    {
        $user = User::find(2);
        $template = Template::where('name', 'Updated Template 2')->firstOrFail();

        Livewire::actingAs($user)
            ->test('template.delete')
            ->call('confirmDelete', $template->id)
            ->call('delete');

        $this->assertDatabaseMissing('audience', ['id' => $template->id]);
    }
}
