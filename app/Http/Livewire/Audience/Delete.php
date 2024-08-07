<?php

namespace App\Http\Livewire\Audience;

use App\Models\Audience;
use Livewire\Component;

class Delete extends Component
{
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
            $this->authorize('DELETE_RESOURCE_USR', $this->audience->user_id);
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('audience.index')->with('message', 'Audience deleted successfully.');
    }
}
