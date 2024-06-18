<?php

namespace App\Http\Livewire\Order;

use App\Models\Billing;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $order;
    public $quote;
    public $quoteNo;
    public $company;
    public $price;
    public $discount;
    public $model;
    public $model_id;
    public $name;
    public $date;
    public $valid_day;
    public $status;
    public $type;
    public $terms;
    public $created_by;
    public $created_role;
    public $addressed;
    public $addressed_name;
    public $addressed_role;
    public $addressed_company;
    public $description;
    public $input;
    public $user;
    public $modalAttach = false;
    public $url;
    public $modalDeleteVisible = false;
    public $customer;
    public $formName;

    public function mount($uuid)
    {

        $this->order = Order::find($uuid);
        $this->user = User::noadmin()->get();
        $this->customer = User::find($this->order->customer_id);
        $this->date = $this->order->date;
        $this->input['name'] = $this->order->name ?? '';
        $this->input['no'] =    'HAPP' . date("YmdHis");
        $this->input['type'] = $this->order->type ?? '';
        $this->input['entity_party'] = $this->order->entity_party ?? '';
        $this->input['customer_type'] = $this->order->customer_type ?? '';
        $this->input['customer_id'] = $this->order->customer_id ?? '';
        $this->input['referrer_id'] = $this->order->referrer_id ?? '';
        $this->input['commision_ratio'] = $this->order->commision_ratio ?? '';
        $this->input['total'] = $this->order->total ?? '';
        $this->input['status'] = $this->order->status ?? '';
        $this->input['source'] = $this->order->source ?? '';
        $this->input['source_id'] = $this->order->source_id ?? '';
        $this->input['date'] = $this->order->date ? $this->order->date->format('Y-m-d') : '';
        $this->input['total'] = $this->order->total ?? '';
    }

    public function rules()
    {


        $data = [
            'input.no' => 'required',
            'input.name' => 'required',
            'input.date' => 'required',

        ];
        if ($this->formName == 'customer') {
            $data = [
                'input.customer_id'       => 'required',
            ];
        }

        return $data;
    }

    public function modelData()
    {
        return [
            'name'              => $this->input['name'],
            'status'            => $this->input['status'],
            'no'                => $this->input['no'],
            'date'              => $this->input['date'],
            'customer_id'       => $this->input['customer_id'],
            'type'              => $this->input['type'],
            'addressed_company' => $this->addressed_company,
            'description'       => $this->description,
            'created_by'        => $this->created_by,
            'created_role'      => $this->created_role,
            'addressed_name'    => $this->addressed_name,
            'addressed_role'    => $this->addressed_role,
        ];
    }

    public function updateStatus($id, $formName = '')

    {
        $this->formName = $formName;
        $this->validate();
        Order::find($id)->update([
            'status' => $this->input['status']
        ]);
        Billing::where('order_id', $id)->update([
            'status' => $this->input['status']
        ]);
        $this->emit('update_status');
    }

    public function onChangeModelId()
    {
        if ($this->order) {
            $this->order->customer_id;
            $customer = User::find($this->input['customer_id']);

            if ($customer) {
                $this->customer = $customer;
            } else {
                $this->customer = NULL;
            }
        } else {
            $this->model = NULL;
            $this->model_id = NULL;
            $this->addressed_company = NULL;
            $this->addressed = '';
        }
    }

    public function actionShowModal($url)
    {
        $this->url = $url;
        $this->modalAttach = true;
    }
    public function update($id)
    {
        // dd($id);
        $this->validate();
        // dd($this->modelData());
        $order = Order::find($id)->update($this->modelData());
        $this->emit('saved');
    }

    public function readClient()
    {
        return $this->order->customer;
    }

    public function actionShowDeleteModal()
    {
        $this->modalDeleteVisible = true;
    }
    public function delete()
    {
        if ($this->order) {
            $this->order->delete();
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.order');
    }

    public function render()
    {
        return view('livewire.order.edit', [
            // 'model_list' => $this->readModelSelection(),
            'client' => $this->readClient(),
            // 'data' => $this->readItem(),
        ]);
    }
}
