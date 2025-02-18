<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;


    public function send()
    {
        $this->validate([
            'email' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
        ], [
            'email' => 'E-mail',
        ]);


        $user = User::where('email', $this->email)->first();

        if (!$user) {
            return $this->addError('email', 'Conta não encontrada.');
        }

        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT){
            session()->flash('success', 'Email enviado com sucesso. Verifique sua caixa de entrada!');
            return redirect(route('login'));
        } else {
            return $this->addError('email', 'Ocorreu algum erro ao enviar o email. Tente novamente mais tarde.');
        }
    }

    public function render()
    {
        return view('livewire.mechanical.auth.forgot-password');
    }
}
