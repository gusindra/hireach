<?php

namespace Tests\Feature;

use App\Http\Livewire\Campaign\Add;
use App\Http\Livewire\Campaign\Edit;
use App\Models\Campaign;
use App\Models\CampaignSchedule;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CampaignTest extends TestCase
{



    public function test_campaign_be_rendered()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('campaign');

        $response->assertStatus(200);
    }

    public function test_can_creates_a_campaign()
    {
        $user = User::find(2);

        Livewire::actingAs($user)
            ->test(Add::class)
            ->set('title', 'Test Campaign')
            ->set('way_type', '1')
            ->call('create')
            ->assertEmitted('refreshLivewireDatatable');

        $this->assertDatabaseHas('campaigns', [
            'title' => 'Test Campaign',
            'way_type' => '1',
            'user_id' => $user->id,
        ]);
    }

    public function test_can_updates_campaign()
    {
        $campaign = Campaign::latest()->first();
        Livewire::actingAs(User::find(2))
            ->test(Edit::class, ['campaign' => $campaign->id])
            ->set('title', 'Updated Title')
            ->set('type', 0)
            ->set('way_type', 1)
            ->set('budget', '2000')
            ->set('is_otp', true)
            ->set('provider', 'provider1')
            ->set('channel', 'EMAIL')
            ->set('text', 'Updated text')
            ->set('from', 'test@gmail.com')
            ->set('to', 'test2@gmail.com')
            ->call('update', $campaign->id)
            ->assertEmitted('saved');

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'title' => 'Updated Title',
            'type' => 0,
            'way_type' => 1,
            'budget' => '2000',
            'is_otp' => true,
            'provider' => 'provider1',
            'channel' => 'EMAIL',
            'text' => 'Updated text',
            'from' => 'test@gmail.com',
            'to' => 'test2@gmail.com',
        ]);
    }



    public function test_it_can_add_a_schedule()
    {
        // Create a campaign
        $campaign = Campaign::factory()->create([
            'shedule_type' => 'daily',
            'loop_type' => 'weekly',
            'user_id' => 2
        ]);

        // Test rendering of the component
        Livewire::test('campaign.add-schedule', ['campaign' => $campaign])
            ->assertSee('Add Schedule')
            ->assertSee('Set the schedule for the campaign.');

        // Test adding a new schedule
        Livewire::test('campaign.add-schedule', ['campaign' => $campaign])
            ->set('typeShedule', 'monthly')
            ->set('dateDay', '1')
            ->set('dateTime', '08:00:00')
            ->call('addSchedule')
            ->assertStatus(200); // Ensure no errors are thrown

        // Assert that the schedule was added to the database
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => '1',
            'time' => '08:00:00',

        ]);
    }



    public function test_can_delete_campaign()
    {

        $user = User::find(2);
        $campaign = Campaign::latest()->first();


        $this->assertDatabaseHas('campaigns', ['id' => $campaign->id]);
        Livewire::actingAs($user)
            ->test('campaign.delete', ['campaignId' => $campaign->id])
            ->call('delete');

        $this->assertSoftDeleted('campaigns', ['id' => $campaign->id]);
    }
}
