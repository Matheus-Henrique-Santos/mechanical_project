<?php

namespace App\Traits\Livewire;

trait WithToast
{
    public function openToast($title,$message, $type = 'success')
    {
        $this->emitTo('component.toast', 'openToast', $title, $message, $type);

        $this->dispatchBrowserEvent('toast-observer');
    }

    public function closeToast()
    {
        $this->emitTo('component.toast', 'closeToast');
    }
}
