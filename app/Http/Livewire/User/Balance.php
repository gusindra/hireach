<?php

namespace App\Http\Livewire\User;

use App\Models\Notification as ModelsNotification;
use App\Models\SaldoUser;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LowBalanceNotification;
use Illuminate\Support\Facades\Auth;

class Balance extends Component
{
    public $saldoUser;
    public $showMessage = false;

    public function mount($userId)
    {

        $this->saldoUser = SaldoUser::find($userId)->latest()->first();
        $notifications = ModelsNotification::where('user_id', $userId)
            ->where('status', 'unread')
            ->get();



        if ($this->saldoUser->balance <= 10000 && $notifications->count() == 0) {
            ModelsNotification::create([
                'type' => 'Top Up',
                'model_id' => $this->saldoUser->id,
                'model' => 'Balance',
                'notification' =>  'Balance Alert. Your current balance remaining Rp' . number_format($this->saldoUser->balance),
                'user_id' => $userId,
                'status' => 'unread'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.balance');
    }
}
