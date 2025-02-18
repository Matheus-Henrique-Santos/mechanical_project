<?php

namespace App\Livewire\Component;

use App\Traits\Livewire\WithModal;
use Livewire\Component;

class ModalConfirm extends Component
{
    use WithModal;
    public $show = false;

    public $icon;
    public $title;
    public $message;
    public $confirmButtonText = 'Sim';
    public $cancelButtonText = 'Não';
    public $eventName;
    public $colorButton;
    public $eventParam;
    public $withoutQuantity;
    public $closeModal = true;
    public $isSafari = false;
    public $proposalUrl = false;

    protected $listeners = ['showModal' => 'open', 'closeModal' => 'close'];
    public function open($icon,  $title, $message, $eventName, $eventParam, $confirmButtonText = 'Sim', $cancelButtonText = 'Não', $withoutQuantity, $closeModal, $isSafari, $proposalUrl, $colorButton)
    {
        $this->show = true;
        $this->closeModal = $closeModal;
        $this->icon = $icon;
        $this->title = $title;
        $this->message = $message;
        $this->confirmButtonText = $confirmButtonText;
        $this->cancelButtonText = $cancelButtonText;
        $this->eventName = $eventName;
        $this->eventParam = json_encode($eventParam);
        $this->withoutQuantity = $withoutQuantity;
        $this->isSafari = $isSafari;
        $this->colorButton = $colorButton;
        $this->proposalUrl = $proposalUrl;
    }

    public function close($close = null)
    {
        if ($close) {
            $this->closeModal(2);
        }
        $this->show = false;

        $this->reset();
    }

    public function render()
    {
        return view('livewire.component.modal-confirm');
    }
}
