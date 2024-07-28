<?php

namespace App\Http\Livewire\Audience;

use App\Models\Audience;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;
    public $modalDeleteVisible = false;
    public $audienceId;
    public $audience;

    protected $listeners = ['confirmDelete'];

    public function confirmDelete($id)
    {
        $this->modalDeleteVisible = true;
        $this->audienceId = $id;
        $this->audience = Audience::find($id);
    }

    public function render()
    {
        return view('livewire.audience.delete', [
            'audience' => $this->audience
        ]);
    }

    public function delete()
    {
        if ($this->audience) {
            $this->audience->delete();
            $this->authorize('DELETE_RESOURCE', $this->audience->user_id);
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('audience.index')->with('message', 'Audience deleted successfully.');
    }
}
