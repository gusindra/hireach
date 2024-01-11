<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Trix extends Component
{
    public $value;
    public $trixId;

    public function mount($value = ''){
        $this->value = $value;
        $this->trixId = 'trix-' . uniqid();
    }

    public function render()
    {
        return view('livewire.trix');
    }
}
