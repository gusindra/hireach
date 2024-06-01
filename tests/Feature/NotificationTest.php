<?php

namespace Tests\Feature;

use App\Http\Livewire\Setting\Notification\Add;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /**
     * test_it_sends_notification_to_individual_users
     *
     * @return void
     */
    public function test_it_sends_notification_to_individual_users()
    {
        $user = User::find(1);
        $recipient =  User::find(1);

        $this->actingAs($user);

        Livewire::test(Add::class)
            ->set('grouptype', 'user')
            ->set('input', [
                'type' => 'info',
                'message' => 'Test message',
                'group' => [$recipient->id],
            ])
            ->call('sendAction');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $recipient->id,
            'notification' => 'Test message',
        ]);
    }
}
