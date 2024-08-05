<?php

namespace App\Http\Livewire\Template;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Template;
use App\Models\Action;
use App\Models\DataAction;

class AddAction extends Component
{
    use AuthorizesRequests;
    public $template;
    public $templateId;
    public $actionId;
    public $message;
    public $is_multidata;
    public $array_data;
    public $modalActionVisible = false;
    public $confirmingActionRemoval = false;
    public $link_attachment;
    public $type;
    public $content = 'text';

    public function mount($template)
    {

        $this->template = $template;
        $this->templateId = $this->template->id;
        $this->type = false;
    }

    public function rules()
    {
        if ($this->link_attachment == '') {
            return [
                'message' => 'required',
            ];
        } else {
            return [
                'link_attachment' => 'required',
            ];
        }
    }

    public function modelData()
    {
        $template = Template::find($this->templateId);
        $data = [
            'message' => $this->message,
            'order' => $this->orderAction(),
            'template_id' => $this->templateId,
            'type' => $this->content
        ];

        if ($template && $template->question && $template->question->type == 'api') {
            $data['is_multidata'] = $this->is_multidata;
            $data['array_data'] = $this->array_data;
        }

        if ($this->link_attachment != '') {
            $data['message'] = $this->link_attachment;
            $ext = attachmentExt($this->link_attachment);
            if ($ext) {
                $data['type'] = $ext;
            }
        }

        return $data;
    }



    public function create()
    {
        $this->validate();

        $action = Action::create($this->modelData());
        $this->modalActionVisible = false;
        $this->resetForm();
        $this->emit('added');
        $this->emit('addArrayData', $action->id);
        $this->actionId = null;
        $this->updateShowModal($action->id);
    }



    /**
     * The update function.
     *
     * @return void
     */
    public function update()
    {
        $this->authorize('UPDATE_CONTENT_USR', $this->template->user_id);
        $this->validate();

        if ($this->link_attachment == '') {
            $data = [
                'message' => $this->message,
                'is_multidata' => $this->is_multidata,
                'array_data' => $this->array_data,
                'type' => 'text'
            ];
        } else {
            $ext = attachmentExt($this->link_attachment);
            if ($ext) {
                $data = [
                    'message' => $this->link_attachment,
                    'is_multidata' => $this->is_multidata,
                    'array_data' => $this->array_data,
                    'type' => $ext
                ];
            } else {
                dd('format false');
            }
        }

        Action::find($this->actionId)->update($data);
        $this->modalActionVisible = false;

        $this->emit('saved');
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        $this->authorize('DELETE_CONTENT_USR', $this->template->user_id);
        Action::destroy($this->actionId);
        $this->actionId = null;
        $this->confirmingActionRemoval = false;

        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Deleted Page',
            'eventMessage' => 'The page (' . $this->actionId . ') has been deleted!',
        ]);
    }

    public function resetForm()
    {
        $this->message = null;
        $this->link_attachment = null;
    }



    public function orderAction()
    {
        return Action::where('template_id', $this->templateId)->count() + 1;
    }

    public function actionShowModal()
    {
        $this->modalActionVisible = true;
        $this->resetForm();
        $this->actionId = null;
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return Action::orderBy('order', 'asc')->where('template_id', $this->templateId)->get();
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetForm();
        $this->actionId = $id;
        $this->modalActionVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Action::find($this->actionId);

        $this->type = false;
        if ($data->type == 'text') {
            $this->message = $data->message;
        } else {
            $this->type = true;
            $this->link_attachment = $data->message;
            $this->message = '';
        }
        $this->is_multidata = $data->is_multidata;
        $this->array_data = $data->array_data;
    }

    public function deleteShowModal($id)
    {
        $this->actionId = $id;
        $data = Action::find($this->actionId);
        $this->message = $data->message;
        $this->confirmingActionRemoval = true;
    }

    public function render()
    {
        return view('livewire.template.add-action', [
            'data' => $this->read(),
        ]);
    }
}
