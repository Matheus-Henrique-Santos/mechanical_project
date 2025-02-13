<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\User;
use Livewire\Component;

class Register extends Component
{
    public $formData = [];

    public function save()
    {
        $validatedData = $this->validate([
            'formData.name' => 'required',
            'formData.email' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
        ], [
            'formData.name' => 'Nome',
        ]);

        User::create([
            'name' => $validatedData['formData']['name'],
            'email' => $validatedData['formData']['email'],
        ]);
    }

    public function render()
    {
        return view('livewire.mechanical.auth.register');
    }
}
