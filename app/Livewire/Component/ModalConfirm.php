<?php

namespace App\Livewire\Component;

use App\Traits\Livewire\WithModal;
use Livewire\Component;

class ModalConfirm extends Component
{
    use WithModal;

    public $show = false;

    public $icon = 'add';
    public $title = '';
    public $message = '';
    public $confirmButtonText = 'Sim';
    public $cancelButtonText = 'Não';
    public $eventName = '';
    public $colorButton = 'red';
    public $eventParam = [];
    public $withoutQuantity = null;
    public $closeModal = true;
    public $isSafari = false;
    public $proposalUrl = null;

    protected $listeners = ['showModalConfirm' => 'open', 'closeModal' => 'close'];

    public function open(
        string $title,
        string $message,
        string $eventName,
        array $eventParam = [],
        string $icon = 'add',
        string $confirmButtonText = 'Sim',
        string $cancelButtonText = 'Não',
        bool $withoutQuantity = null,
        bool $closeModal = true,
        bool $isSafari = false,
        ?string $proposalUrl = null,
        string $colorButton = 'red'
    ) {
        $this->show = true;
        $this->icon = $icon;
        $this->title = $title;
        $this->message = $message;
        $this->confirmButtonText = $confirmButtonText;
        $this->cancelButtonText = $cancelButtonText;
        $this->eventName = $eventName;
        $this->eventParam = json_encode($eventParam);
        $this->withoutQuantity = $withoutQuantity;
        $this->closeModal = $closeModal;
        $this->isSafari = $isSafari;
        $this->proposalUrl = $proposalUrl;
        $this->colorButton = $colorButton;
    }

    public function close()
    {
        $this->show = false;
        $this->resetExcept(['icon', 'colorButton']);
    }

    public function render()
    {
        return view('livewire.component.modal-confirm');
    }
}
