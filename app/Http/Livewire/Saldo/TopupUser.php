<?php

namespace App\Http\Livewire\Saldo;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Team;
use App\Jobs\ProcessEmail;
use Illuminate\Support\Facades\Cache;

class TopupUser extends Component
{
    public $nominal = '100000';
    public $nominal_view;

    public function mount()
    {
        $this->nominal_view = number_format($this->nominal);
    }

    public function rules()
    {
        return [
            'nominal' => 'required'
        ];
    }

    public function dataOrder()
    {
        $data = [
            'date' => date("Y-m-d H:i:s"),
            'name' => 'Request Topup from ' . Auth::user()->name,
            'no' => 'HAPP' . date("YmdHis"),
            'type' => 'selling',
            'entity_party' => '1',
            'total' => 0,
            'status' => 'unpaid',
            'customer_id' => $this->chechClient(),
            'user_id' => 0,
        ];
        return $data;
    }

    private function chechClient()
    {
        $client = Auth::user();
        try {
            $customer = Client::where('email', $client->email)->where('user_id', 0)->firstOr(function () use ($client) {
                return Client::create([
                    'name' => $client->name,
                    'phone' => '00000',
                    'email' => $client->email,
                    'user_id' => 0,
                    'uuid' => Str::uuid()
                ]);
            });
            $team = Team::find(0);
            $customer->teams()->attach($team);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
        return $customer->uuid;
    }

    public function create()
    {
        $vat = cache('vat_setting');
        if (empty($vat)) {

            $vat = cache()->remember('vat_setting', 1444, function () {
                return Setting::where('key', 'vat')->latest()->first();
            });

        }



        $this->validate();
        try {
            $order = Order::create($this->dataOrder());
            if ($order) {
                OrderProduct::updateOrCreate(
                    [
                        'model' => 'Order',
                        'model_id' => $order->id,
                        'name' => 'Topup'
                    ],
                    [
                        'qty' => 1,
                        'unit' => 1,
                        'price' => $this->nominal,
                        'note' => 'Topup',
                        'user_id' => 0,
                    ]
                );
                OrderProduct::updateOrCreate(
                    [
                        'model' => 'Order',
                        'model_id' => $order->id,
                        'name' => 'Tax'
                    ],
                    [
                        'qty' => 1,
                        'unit' => 1,
                        'price' => $this->nominal * ($vat->value / 100),
                        'note' => 'VAT/PPN @ '.$vat->value.'%',
                        'user_id' => 0,
                    ]
                );
            }

            //ProcessEmail::dispatch($order, 'create_order');

            return redirect()->to('/payment/invoice/' . $order->id);
        } catch (\Throwable $th) {
            //throw $th;
            dd('Mohon Tambahkan VAT pada setting');
        }
        $this->emit('fail');
    }

    public function onClickNominal($value)
    {
        $this->nominal = $value;
        $this->nominal_view = number_format($value);
    }

    public function render()
    {
        return view('livewire.saldo.topup-user');
    }
}
