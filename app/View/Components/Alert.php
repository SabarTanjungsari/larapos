<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    /**
     * The priority of the alert, i.e., "info", or "warning"
     *
     * @var string
     */
    public $type;

    /**
     * The message or an array of messages to present to the user
     *
     * @var mixed
     */
    public $slot;

    /**
     * Create a new component instance.
     *
     * @param  string  $level
     * @param  mixed   $message
     */
    public function __construct(string $type, $slot)
    {
        $this->type = $type;
        $this->slot = $slot;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
