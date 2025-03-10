<?php

namespace App\Livewire\Component;

use App\Traits\Livewire\WithModal;
use Livewire\Component;

class ModalHelp extends Component
{
    public $show = false;
    public $component = '';
    public $params = [];

    protected $listeners = ['showModalHelp' => 'open', 'closeModal' => 'close'];

    public function open($component, $params = [])
    {
        $this->show = true;

        $this->component = $component;
        $this->params = $params;
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.component.modal-help');
    }
}
