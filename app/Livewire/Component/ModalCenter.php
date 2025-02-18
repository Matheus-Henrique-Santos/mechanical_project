<?php

namespace App\Livewire\Component;

use Livewire\Component;

class ModalCenter extends Component
{
    public $show = false;
    public $component = '';
    public $params = [];
    public $form = null;
    public $site = null;

    protected $listeners = ['showModalCenter' => 'open', 'closeModal' => 'close'];

    public function open($component, $params = [], $form = null, $site = null)
    {
        $this->show = true;
        $this->component = $component;
        $this->params = $params;
        $this->form = $form;
        $this->site = $site;
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.component.modal-center');
    }
}
