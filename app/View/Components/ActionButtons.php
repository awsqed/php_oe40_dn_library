<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButtons extends Component
{

    public $action;
    public $route;
    public $target;

    public function __construct($action, $route, $target)
    {
        $this->action = $action;
        $this->route = $route;
        $this->target = $target;
    }

    public function render()
    {
        return view('components.action-buttons');
    }

}
