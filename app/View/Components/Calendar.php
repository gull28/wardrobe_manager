<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public $val;
    /**
     * Create a new component instance.
     */
    public function __construct($val = [
        'testData' => 'testData'
    ]){
        $this->val = $val;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar');
    }
}
