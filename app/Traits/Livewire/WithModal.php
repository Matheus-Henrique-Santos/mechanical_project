<?php

namespace App\Traits\Livewire;

trait WithModal
{
    public function openModal($component, $params = [], $level = 1)
    {
        if($level === 2) {
            $this->dispatch('component.modal-nivel2', 'showModal', $component, $params);
            return;
        }

        if($level === 3) {
            $this->dispatch('component.modal-nivel3', 'showModal', $component, $params);
            return;
        }

        if($level === 4) {
            $this->dispatch('component.modal-nivel4', 'showModal', $component, $params);
            return;
        }

        $this->dispatch('component.modal-nivel1', 'showModal', $component, $params);
    }

    public function openCenterModal($component, $params = [], $form = null, $site = null)
    {
        $this->dispatch('component.modal-center', 'showModal', $component, $params, $form, $site);
    }

    public function closeCenterModal()
    {
        $this->dispatch('component.modal-center', 'closeModal');
    }

    public function openConfirmModal($icon, $title, $message,  $eventName, $eventParam, $confirmButtonText = 'Sim', $cancelButtonText = 'Não', $withoutQuantity = null, $closeModal = true, $isSafari = null, $proposalUrl = null, $colorButton = 'red')
    {
        $this->dispatch('component.modal-confirm', 'showModal', $icon, $title, $message, $eventName, $eventParam, $confirmButtonText, $cancelButtonText, $withoutQuantity, $closeModal, $isSafari, $proposalUrl, $colorButton);
    }

    public function openHelpModal($component, $params = [])
    {
        $this->dispatch('component.modal-help', 'showModal', $component, $params);
    }

    public function closeHelpModal($level = 1)
    {
        $this->dispatch('component.modal-help', 'closeModal');
    }

    public function closeConfirmModal()
    {
        $this->dispatch('component.modal-confirm', 'closeModal');
    }

    public function closeModal($level = 1)
    {
        if($level === 2) {
            $this->dispatch('component.modal-nivel2', 'closeModal');
            return;
        }

        if($level === 3) {
            $this->dispatch('component.modal-nivel3', 'closeModal');
            return;
        }

        if($level === 4) {
            $this->dispatch('component.modal-nivel4', 'closeModal');
            return;
        }

        $this->dispatch('component.modal-nivel1', 'closeModal');
    }
}
