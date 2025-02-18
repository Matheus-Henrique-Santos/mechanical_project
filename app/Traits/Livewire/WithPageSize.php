<?php

namespace App\Traits\Livewire;

trait WithPageSize
{
    public $pageSize = 15;

    public function updatedPageSize()
    {
        $this->resetPage();
    }
}
