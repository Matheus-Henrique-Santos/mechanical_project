<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $remember = false;

    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        $validatedData = $this->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
        ], [
            'email' => 'E-mail',
            'password' => 'Senha',
        ]);

        $remember = (bool)$this->remember;

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return $this->addError('email', 'Conta não encontrada.');
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return $this->addError('password', 'Senha inválida.');
        }

        Auth::login($user, $remember);

        session()->regenerate();

        return redirect('dashboard');
    }

    public function render()
    {
        return view('livewire.mechanical.auth.login');
    }
}
