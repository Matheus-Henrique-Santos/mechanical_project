<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Ramsey\Uuid\Uuid;

class SideModal extends Component
{
    public $componentName, $uuid;
    public $params = [];
    public $events = [];

    #[On('open-side-modal')]
    public function sideModal($componentName,$params = [],$events = []): void
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->componentName = $componentName;
        $this->params = $params;
        if ($events) {
            $this->triggerEvents($events);
        }
    }

    #[On('close-side-modal')]
    public function closeModal($events = []): void
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

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.side-modal');
    }
}
