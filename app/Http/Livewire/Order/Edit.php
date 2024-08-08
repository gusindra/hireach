<?php

namespace App\Http\Livewire\Order;

use App\Models\Billing;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{
    use AuthorizesRequests;

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
    public $nominal;
    public $selectedName = '';
    public $search = '';
    public $selectedId = null;
    public $disable = false;
    public $nominal_view;
    public $paid_at;

    /**
     * mount
     *
     * @param  mixed $uuid
     * @return void
     */
    public function mount($uuid)
    {
        $this->order = Order::find($uuid);
        $this->user = [];
        $this->customer = Client::where('uuid', $this->order->customer_id)->first();
        $this->date = $this->order->date;
        $this->input['name'] = $this->order->name ?? '';
        $this->input['no'] = 'HAPP' . date("YmdHis");
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
        $this->nominal = $this->order->total ?? '';
        $this->disable = $this->disableInput($this->order->status);
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
                'input.customer_id' => 'required',
            ];
        }

        return $data;
    }

    public function modelData()
    {
        return [
            'name' => $this->input['name'],
            'status' => $this->input['status'],
            'no' => $this->input['no'],
            'date' => $this->input['date'],
            'customer_id' => $this->input['customer_id'],
            'type' => $this->input['type'],
            'addressed_company' => $this->addressed_company,
            'total' => $this->nominal,
            'description' => $this->description,
            'created_by' => $this->created_by,
            'created_role' => $this->created_role,
            'addressed_name' => $this->addressed_name,
            'addressed_role' => $this->addressed_role,
        ];
    }


    /**
     * onClickNominal
     *
     * @param  mixed $value
     * @return void
     */
    public function onClickNominal($value)
    {
        $this->nominal = $value;
        $this->nominal_view = number_format($value);
    }

    /**
     * disableInput
     *
     * @param  mixed $status
     * @return void
     */
    public function disableInput($status)
    {
        return $status === 'unpaid';
    }

    /**
     * selectItem
     *
     * @param  mixed $id
     * @return void
     */
    public function selectItem($id)
    {
        $client = Client::where('uuid', $id)->first();
        if ($client) {
            $this->search = $client->name;
            $this->selectedId = $client->uuid;
            $this->input['customer_id'] = $client->uuid;
            $this->emit('updateCustomerId', $client->uuid);
        }

    }

    /**
     * updateStatus
     *
     * @param  mixed $id
     * @param  mixed $formName
     * @return void
     */
    public function updateStatus($id, $formName = '')
    {
        $this->authorize('UPDATE_ORDER', 'ORDER');
        $this->formName = $formName;
        $this->validate();
        $datetime = Carbon::parse($this->paid_at);
        Order::find($id)->update([
            'status' => $this->input['status']
        ]);
        Billing::where('order_id', $id)->update([
            'status' => $this->input['status'],
            'paid_at' => $datetime->format('Y-m-d H:i:s')
        ]);
        $this->emit('update_status');
        return redirect(request()->header('Referer'));
    }

    /**
     * inputCustomer
     *
     * @param  mixed $uuid
     * @return void
     */
    public function inputCustomer($uuid)
    {
        if ($this->order) {
            $customer = Client::where('uuid', $uuid)->first();
            $this->customer = $customer ?? null;
            $this->input['customer_id'] = $uuid;

            $this->search = $customer->name ?? '';
        } else {
            $this->model = null;
            $this->model_id = null;
            $this->addressed_company = null;
            $this->addressed = '';
        }
    }

    /**
     * actionShowModal
     *
     * @param  mixed $url
     * @return void
     */
    public function actionShowModal($url)
    {
        $this->url = $url;
        $this->modalAttach = true;
    }

    /**
     * update
     *
     * @param  mixed $id
     * @return void
     */
    public function update($id)
    {
        $this->authorize('UPDATE_ORDER', $this->customer->user_id);
        $this->validate();
        // dd($this->modelData());
        $order = Order::find($id)->update($this->modelData());

        $bill = Billing::updateOrCreate([
            'uuid' => Str::uuid(),
            'status' => 'unpaid',
            'code' => $this->input['no'],
            'description' => $this->name,
            'amount' => $this->nominal,
            'order_id' => $this->order->id,
        ]);

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
        $clients = Client::query()
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('phone', 'like', "%{$this->search}%")
            ->orWhere('email', 'like', "%{$this->search}%")
            ->limit(5)
            ->get();
        return view('livewire.order.edit', [
            // 'model_list' => $this->readModelSelection(),
            'client' => $this->readClient(),
            'clients' => $clients
            // 'data' => $this->readItem(),
        ]);
    }
}
