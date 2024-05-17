<?php

namespace App\Http\Livewire\User;

use App\Models\Notification as ModelsNotification;
use App\Models\SaldoUser;
use Livewire\Component;

class Balance extends Component
{
    public $saldoUser;
    public $showMessage = false;

    public function mount($userId)
    {
        if (!$userId) {
            return;
        }

        $saldoUser = SaldoUser::where('id', $userId)->first();

        if (!$saldoUser) {
            $this->createNotification($userId, 'Balance Alert. Your current balance is empty.');
            return;
        }

        $this->saldoUser = $saldoUser;

        if ($this->saldoUser->balance <= 10000) {
            $notificationMessage = 'Balance Alert. Your current balance remaining Rp' . number_format($this->saldoUser->balance);
            $this->createNotification($userId, $notificationMessage);
        }
    }

    public function render()
    {
        return view('livewire.user.balance');
    }

    private function createNotification($userId, $message)
    {
        ModelsNotification::create([
            'type' => 'Top Up',
            'model_id' => $userId,
            'model' => 'Balance',
            'notification' => $message,
            'user_id' => $userId,
            'status' => 'unread'
        ]);
    }
}
