<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;
    public $modalDeleteVisible = false;
    public $templateId;
    public $template;

    protected $listeners = ['confirmDelete'];

    public function confirmDelete($id)
    {
        $this->modalDeleteVisible = true;
        $this->templateId = $id;
        $this->template = Template::find($id);
    }

    public function render()
    {
        return view('livewire.template.delete', [
            'template' => $this->template
        ]);
    }

    public function delete()
    {

        if ($this->template) {
            $this->template->delete();
            $this->authorize('DELETE_CONTENT_USR', $this->template->id);
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('template')->with('message', 'Template deleted successfully.');
    }
}
