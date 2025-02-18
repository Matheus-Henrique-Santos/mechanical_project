<?php

namespace App\Traits\Livewire;

trait WithModal
{
    public function openModal($component, $event, $params = [], $level = 1)
    {
        $modal = match ($level) {
            2 => 'component.modal-nivel2',
            3 => 'component.modal-nivel3',
            4 => 'component.modal-nivel4',
            default => 'component.modal-nivel1',
        };

        $this->dispatch($event, component: $modal, params: [$component, $params]);
    }

    public function openCenterModal($component, $params = [], $form = null, $site = null)
    {
        $this->dispatch('showModal', component: 'component.modal-center', params: [$component, $params, $form, $site]);
    }

    public function closeCenterModal()
    {
        $this->dispatch('closeModal', component: 'component.modal-center');
    }

    public function openConfirmModal(
        $icon = 'add',
        $title,
        $message,
        $eventName,
        $eventParam,
        $confirmButtonText = 'Sim',
        $cancelButtonText = 'Não',
        $withoutQuantity = null,
        $closeModal = true,
        $isSafari = null,
        $proposalUrl = null,
        $colorButton = 'red'
    ) {
        $this->dispatch('showModal', component: 'component.modal-confirm', params: [
            $icon, $title, $message, $eventName, $eventParam, $confirmButtonText,
            $cancelButtonText, $withoutQuantity, $closeModal, $isSafari, $proposalUrl, $colorButton
        ]);
    }

    public function openHelpModal($component, $params = [])
    {
        $this->dispatch('showModal', component: 'component.modal-help', params: [$component, $params]);
    }

    public function closeHelpModal()
    {
        $this->dispatch('closeModal', component: 'component.modal-help');
    }

    public function closeConfirmModal()
    {
        $this->dispatch('closeModal', component: 'component.modal-confirm');
    }

    public function closeModal($level = 1)
    {
        $modal = match ($level) {
            2 => 'component.modal-nivel2',
            3 => 'component.modal-nivel3',
            4 => 'component.modal-nivel4',
            default => 'component.modal-nivel1',
        };

        $this->dispatch('closeModal', component: $modal);
    }
}
