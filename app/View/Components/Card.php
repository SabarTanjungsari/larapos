<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $slot;
    public $footer;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $slot, $footer)
    {
        $this->title = $title;
        $this->slot = $slot;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
