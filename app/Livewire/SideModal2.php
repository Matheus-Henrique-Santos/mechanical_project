<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class SideModal2 extends Component
{
    public $componentName;
    public $params = [];
    public $events = [];
    public $uuid;

    #[On('open-side-modal2')]
    public function sideModal($componentName,$params = [],$events = []): void
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->componentName = $componentName;
        $this->params = $params;
        if ($events) {
            $this->triggerEvents($events);
        }
    }

    #[On('close-side-modal2')]
    public function closeModal1($events = []): void
    {
        if ($events) {
            $this->triggerEvents($events);
        }
    }

    public function triggerEvents($events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function render()
    {
        return view('livewire.side-modal2');
    }
}
