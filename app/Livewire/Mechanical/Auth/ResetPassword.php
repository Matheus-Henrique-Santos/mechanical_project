<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{

    public $token, $email, $password, $password_confirmation, $authorize = false;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email');

        $verifyToken = DB::table('password_reset_tokens')->where('email', $this->email)->first();

        if (!$verifyToken || !Hash::check($this->token, $verifyToken->token)) {
            session()->flash('error', 'Token inválido ou já utilizado.');
            return redirect()->route('password.request');
        }

        $this->authorize = true;
    }

    public function resetPassword()
    {
        if ($this->password !== $this->password_confirmation) {
            return $this->addError('password_confirmation', 'As senhas não conferem');
        }

        $this->validate([
            'password' => 'required|min:8',
        ], [
            'required' => 'A :attribute é obrigatória',
            'confirmed' => 'A :attribute não conferem.',
            'min' => 'A :attribute precisa ter no minimo :min caracteres.',
        ], [
            'password' => 'Senha',
        ]);

        $alterPasswd = User::query()->where('email', $this->email)->update(['password' => Hash::make($this->password)]);

        if ($alterPasswd) {
            session()->flash('success', 'Senha alterada com sucesso');
            return redirect()->route('login');
        }
    }


    public function render()
    {
        return view('livewire.mechanical.auth.reset-password');
    }
}
