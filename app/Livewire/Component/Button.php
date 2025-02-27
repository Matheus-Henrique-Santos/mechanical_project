<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Button extends Component
{
    public $text, $component, $level, $params, $classList;

    public function mount($text = '', $component = '', $level = '', $params = '', $classList = '')
    {
        $this->text = $text;
        $this->component = $component;
        $this->level = $level;
        $this->params =  $params;
        $this->classList = $classList;
    }

    public function render()
    {
        return view('livewire.component.button');
    }
}
