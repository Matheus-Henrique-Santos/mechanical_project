<?php

namespace App\Livewire\Mechanical\User;

use Livewire\Component;
use function view;

class Filter extends Component
{
    protected $listeners = [
        'clearFilter'
    ];

    public $state = [
        'name' => '',
    ];

    public function submit()
    {
        $this->emit('filterUser', $this->state);
    }

    public function clearFilter()
    {
        $this->reset();
        $this->submit();
    }

    public function render()
    {
        return view('livewire.mechanical.user.filter');
    }
}
