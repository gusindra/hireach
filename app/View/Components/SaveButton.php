<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SaveButton extends Component
{
    public $show;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($show, $type='submit')
    {
        $this->show = $show;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.save-button');
    }
}
