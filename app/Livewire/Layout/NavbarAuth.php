<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class NavbarAuth extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.layout.navbar-auth');
    }
}
