<?php

namespace App\Http\Livewire\Template;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Template;

class EditTrigger extends Component
{
    use AuthorizesRequests;
    public $template;
    public $templateId;
    public $trigger;
    public $trigger_condition;
    public $uuid;

    public function mount($template)
    {
        $this->template = Template::with('questionError')->find($template->id);
        $this->trigger = $this->template->trigger;
        $this->trigger_condition = $this->template->trigger_condition;
        $this->templateId = $this->template->id;
    }

    public function rules()
    {
        return [
            'trigger' => 'required',
            'trigger_condition' => 'required',
        ];
    }

    public function modelData()
    {
        return [
            'trigger' => $this->trigger,
            'trigger_condition' => $this->trigger_condition
        ];
    }

    /**
     * Update Trigger
     *
     * @return void
     */
    public function updateTrigger()
    {
        $this->authorize('UPDATE_CONTENT_USR', $this->template->user_id);
        $this->validate();
        Template::find($this->templateId)->update($this->modelData());
        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.template.edit-trigger');
    }
}
