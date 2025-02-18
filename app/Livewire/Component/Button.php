<?php

namespace App\Livewire\Component;

use App\Traits\Livewire\WithModal;
use Livewire\Component;

class Button extends Component
{
    use WithModal;

    public $text;
    public $icon;
    public $component;
    public $level = 1;

    public function mount($text, $icon = null, $component, $level = 1)
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->component = $component;
        $this->level = $level;
    }

    public function render()
    {
        return view('livewire.component.button');
    }
}
