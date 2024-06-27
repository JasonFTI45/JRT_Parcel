<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrintLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.print');
    }
}