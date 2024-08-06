<?php

namespace Tests\Feature;

use App\Http\Livewire\DeleteNotification;
use App\Http\Livewire\Setting\Notification\Add;
use App\Models\Notice;
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
    public function test_notification_center_can_be_rendered()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('notif-center');

        $response->assertStatus(200);
    }


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

        $this->assertDatabaseHas('notices', [
            'user_id' => $recipient->id,
            'notification' => 'Test message',
        ]);
    }


    public function test_it_deletes_the_notification()
    {
        $notification = Notice::latest()->first();
        $user = User::find(1);
        Livewire::actingAs($user)->test(DeleteNotification::class, ['notificationId' => $notification->id])
            ->call('deleteNotification', $notification->id);

        $this->assertSoftDeleted('notices', ['id' => $notification->id]);
        $notification->forceDelete();
    }
}
