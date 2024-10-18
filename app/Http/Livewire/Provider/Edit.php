<?php

namespace App\Http\Livewire\Provider;

use App\Models\BlastMessage;
use App\Models\CommerceItem;
use App\Models\Provider;
use App\Models\SaldoUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;
    public $provider;
    public $name;
    public $company;
    public $code;
    public $status;
    public $channel;
    public $uuid;
    public $modalDeleteVisible = false;
    public $selectedSku;
    public $selectedChannels = [];
    public $commerceItem;
    public $item;
    public $type;

    public $topupAmount;
    public $usageProviderData;



    /**
     * mount
     *
     * @param  mixed $uuid
     * @return void
     */
    public function mount($uuid)
    {

        $this->provider = Provider::find($uuid);
        $this->name = $this->provider->name;
        $this->code = $this->provider->code;
        $this->company = $this->provider->company;
        $this->channel = $this->provider->channel;
        $this->type = $this->provider->type;
        $this->status = $this->provider->status;
        $this->commerceItem = CommerceItem::all();
        $this->selectedChannels = explode(',', $this->provider->channel);
        $this->usageProviderData = $this->usageProvider($uuid);
    }

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'company' => 'string',
            'channel' => 'required'
        ];
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'company' => $this->company,
            'type' => $this->type,
            'channel' => $this->channel
        ];
    }


    /**
     * update
     *
     * @param  mixed $id
     * @return void
     */
    public function update($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        $this->validate();
        Provider::find($id)->update($this->modelData());
        $this->emit('saved');
    }

    /**
     * updateStatus
     *
     * @param  mixed $id
     * @return void
     */
    public function updateStatus($id)
    {
        $this->authorize('UPDATE_SETTING', 'SETTING');
        Provider::find($id)->update(['status'=>!$this->provider->status]);
        $this->provider->status = !$this->provider->status;
        $this->emit('updated');
        return redirect(request()->header('Referer'));
    }

    /**
     * actionShowDeleteModal
     *
     * @return void
     */
    public function actionShowDeleteModal()
    {
        $this->modalDeleteVisible = true;
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $this->authorize('DELETE_SETTING', 'SETTING');
        if ($this->provider) {
            $this->provider->delete();
        }
        $this->modalDeleteVisible = false;
        return redirect()->route('admin.settings.provider');
    }


    public function updatedSelectedSku($value)
    {
        $value = strtoupper($value);

        if ($value && !in_array($value, $this->selectedChannels)) {
            $this->selectedChannels[] = $value;
            $this->saveChannel();
        }

        $this->selectedSku = null;
    }

    public function removeChannel($sku)
    {
        $this->selectedChannels = array_filter($this->selectedChannels, function ($item) use ($sku) {
            return $item !== $sku;
        });

        $this->saveChannel();
    }

    public function saveChannel()
    {
        $this->provider->channel = implode(',', $this->selectedChannels);
        $this->provider->save();
    }

    public function topupProvider($providerId)
    {
        $this->validate([
            'topupAmount' => 'required|numeric|min:1',
        ]);

        $provider = Provider::findOrFail($providerId);

       $saldoUser= SaldoUser::create([
            'user_id' => auth()->user()->id,
            'team_id' => 1,
            'model' => 'Provider',
            'currency' => 'IDR',
            'mutation' => 'credit',
            'model_id' => $provider->id,
            'amount' => $this->topupAmount,
            'description' =>'Topup Provider',
        ]);

        $saldoUser->balance = SaldoUser::where('model', 'provider')
            ->where('model_id', $provider->id)
            ->sum('amount');
        $saldoUser->save();
        $this->emit('topupSuccess');
        return redirect('admin/dashboard/provider');

    }



    public function usageProvider($providerId)
    {
        $totalUsage = BlastMessage::where('provider', $providerId)->get()->sum('price');
        $latestSaldo = SaldoUser::where('model', 'Provider')
                                ->where('model_id', $providerId)
                                ->latest()
                                ->first();

        return [
            'totalUsage' => $totalUsage,
            'latestSaldo' => $latestSaldo ? $latestSaldo->balance : 0
        ];
    }



    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.provider.edit');
    }

}
