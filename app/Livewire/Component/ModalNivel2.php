<?php

namespace App\Livewire\Component;

use Livewire\Component;

class ModalNivel2 extends Component
{
    public $show = false;
    public $component = '';
    public $params = [];

    protected $listeners = ['showModal2' => 'open', 'closeModal' => 'close'];

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
        return view('livewire.component.modal-nivel2');
    }
}
