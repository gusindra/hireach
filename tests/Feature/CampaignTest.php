<?php

namespace Tests\Feature;

use App\Http\Livewire\Campaign\Add;
use App\Http\Livewire\Campaign\Edit;
use App\Models\Campaign;
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





    public function test_can_generate_schedule_for_monday_to_friday()
    {
        $user = User::find(2);
        $campaign = Campaign::latest()->first();
        Livewire::actingAs($user)
            ->test('campaign.add-schedule', ['campaign_id' => $campaign->id])
            ->set('days.monday', true)
            ->set('times.monday', '09:00')
            ->set('days.tuesday', true)
            ->set('times.tuesday', '10:00')
            ->set('days.wednesday', true)
            ->set('times.wednesday', '11:00')
            ->set('days.thursday', true)
            ->set('times.thursday', '12:00')
            ->set('days.friday', true)
            ->set('times.friday', '13:00')
            ->set('days.saturday', true)
            ->set('times.saturday', '14:00')
            ->set('days.sunday', true)
            ->set('times.sunday', '15:00')
            ->call('generateSchedule')
            ->assertHasNoErrors()
            ->assertSee('Schedule generated successfully.');


        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Monday',
            'time' => '09:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Tuesday',
            'time' => '10:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Wednesday',
            'time' => '11:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Thursday',
            'time' => '12:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Friday',
            'time' => '13:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Saturday',
            'time' => '14:00',
        ]);
        $this->assertDatabaseHas('campaigns_schedules', [
            'campaign_id' => $campaign->id,
            'day' => 'Sunday',
            'time' => '15:00',
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
