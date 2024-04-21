<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormDropdown extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $placeholder;

    public function __construct($name, $label, $type, $value = null, $placeholder = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-dropdown');
    }
}
