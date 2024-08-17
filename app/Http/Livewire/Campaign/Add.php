<?php

namespace App\Http\Livewire\Campaign;

use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class Add extends Component
{
    public $modalActionVisible = false;
    public $title;
    public $way_type;
    public $selectType = ['One Way', 'Two Way'];
    public $cacheDuration = 3600;


    protected $rules = [
        'title' => 'required|string|max:255',
        'way_type' => 'required|string|in:1,2',
    ];

    public function create()
    {
        $this->validate();
        $provider = cache()->remember('provider-user-'.auth()->user()->id, $this->cacheDuration, function() {
            $pro = auth()->user()->providerUser->first()->provider;
            if($pro->status){
                return $pro;
            }
        });

        if(!empty($provider)){
        Campaign::create([
            'title' => strip_tags(filterInput($this->title)),
            'way_type' => strip_tags(filterInput($this->way_type)),
            'user_id' => Auth::id(),
            'uuid' => Str::uuid(),
            'type' => 0
        ]);
            $this->modalActionVisible = false;
        }else{
            $this->emit('campaign_failed');
        }

        $this->resetForm();
        $this->emit('refreshLivewireDatatable');
    }

    public function resetForm()
    {
        $this->title = null;
        $this->way_type = '';
    }

    public function actionShowModalOneWay()
    {
        $this->modalActionVisible = true;
    }

    public function render()
    {
        return view('livewire.campaign.add');
    }
}
