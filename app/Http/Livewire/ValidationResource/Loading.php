<?php

namespace App\Http\Livewire\ValidationResource;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProcessSkiptrace;

class Loading extends Component
{
    public $showLoading = false;

    private function readJob()
    {
        $queue = \Illuminate\Support\Facades\DB::table(config('queue.connections.database.table'))->where('payload', 'like', '%:'.auth()->user()->id.'%')->get();
        foreach($queue as $q){
            $payload = json_decode($q->payload,true);
            $payload1 = $payload['data']['command'];
            $getId = explode('userId',$payload1);
            if(strpos($getId[1], auth()->user()->id) !== false){
                $this->showLoading = true;
                return true;
            }
        }
        $this->showLoading = false;
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.validation-resource.loading', [
            'jobs' => $this->readJob(),
        ]);
    }
}
