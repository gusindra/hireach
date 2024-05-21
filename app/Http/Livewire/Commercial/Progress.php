<?php

namespace App\Http\Livewire\Commercial;

use App\Models\Billing;
use App\Models\Commision;
use App\Models\Contract;
use App\Models\FlowProcess;
use App\Models\FlowSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Project;
use App\Models\Quotation;
use Livewire\Component;

class Progress extends Component
{
    public $model;
    public $model_type;
    public $model_id;
    public $approval = false;
    public $remark;
    public $theme;
    public $errorMessage = '';

    public function mount($model, $id)
    {
        $this->model_type = $model;
        $this->model_id = $id;
        if ($model == 'project') {
            $this->model = Project::find($id);
        } elseif ($model == 'quotation') {
            $this->model = Quotation::find($id);
        } elseif ($model == 'contract') {
            $this->model = Contract::find($id);
        } elseif ($model == 'order') {
            $this->model = Order::find($id);
        } elseif ($model == 'commission') {
            $this->model = Commision::find($id);
        } elseif ($model == 'invoice') {
            $this->model = Billing::find($id);
        }
    }


    public function read()
    {
        return FlowProcess::where('model', $this->model_type)->where('model_id', $this->model_id)->get();
    }


    public function activated()
    {
        $this->model->update([
            'status' => 'active'
        ]);

        return redirect(request()->header('Referer'));
        $this->emit('saved');
    }


    public function submit()
    {

        $item =  $this->model->items->count();

        $fields = [
            'title',
            'status',
            'quote_no',
            'date',
            'valid_day',
            'terms',
            'model',
            'model_id',
            'addressed_company',
            'description',
            'created_by',
            'created_role',
            'addressed_name',
            'addressed_role',
        ];


        $this->errorMessage = '';


        foreach ($fields as $field) {

            if (empty($this->model->$field) || $item == 0) {
                $this->errorMessage = 'Please  fill in all fields !';
            }
        }
        if ($this->errorMessage) {
            return;
        }
        $this->model->update([
            'status' => 'submit'
        ]);


        $this->emit('saved');


        return redirect(request()->header('Referer'));
    }

    public function next($status = '')
    {
        $update_status = $status;
        $flow = FlowProcess::create([$this->model->approval]);

        $flow->model_id = $this->model->id;
        $setting = FlowSetting::where('description', $flow->task)->where('role_id', $flow->role_id)->first();
        if ($setting) {
            $update_status = $setting->result_status;
        }
        // dd($update_status);
        $this->model->update([
            'status' => $update_status
        ]);

        $flow->user_id = auth()->user()->id;
        $flow->status = $update_status;
        $flow->comment = $this->remark;

        $flow->save();

        $this->approval = false;

        return redirect(request()->header('Referer'));
        $this->emit('saved');
    }

    public function decline()
    {
        $this->model->update([
            'status' => 'revision'
        ]);

        $flow = FlowProcess::create([$this->model->approval]);
        $flow->model_id = $this->model->id;
        $flow->user_id = auth()->user()->id;
        $flow->status = 'decline';
        $flow->comment = $this->remark;

        $flow->save();

        FlowProcess::where('model', $flow->model)->where('model_id', $flow->model_id)->whereNull('status')->delete();

        return redirect(request()->header('Referer'));
        $this->emit('saved');
    }

    public function revise()
    {
        $this->model->update([
            'status' => 'draft'
        ]);
        $flow = FlowProcess::find($this->model->approval->id);
        FlowProcess::where('model', $flow->model)->where('model_id', $flow->model_id)->delete();
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        if ($this->theme == 1) {
            return view('livewire.commercial.theme.progress', [
                'approvals' => $this->read()
            ]);
        }
        return view('livewire.commercial.progress', [
            'approvals' => $this->read()
        ]);
    }
}
