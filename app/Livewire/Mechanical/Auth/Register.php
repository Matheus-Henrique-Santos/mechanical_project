<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\Tenant;
use App\Models\User;
use App\Notifications\SendEmailNewUsers;
use App\Services\AddressService;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class Register extends Component
{
    public $name, $subdomain, $email, $cellphone, $cnpj;

    public function updatedZipCode()
    {
        $address = AddressService::getAddress($this->zipCode);

        if (!$address) {
            $this->addError('zipCode', 'O  Cep informado não existe.');
        } else {
            $this->formData['address'] = $address['address'] ?? '';
            $this->formData['neighborhood'] = $address['neighborhood'] ?? '';
            $this->formData['uf'] = $address['st'] ?? '';
            $this->formData['city'] = $address['city'] ?? '';
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'subdomain' => 'required|unique:tenants,subdomain',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|celular_com_ddd',
            'cnpj' => 'required|cnpj|unique:tenants,cnpj',
        ], [
            'required' => ':attribute é obrigatório.',
            'unique' => ':attribute já existe cadastro.',
            'min' => ':attribute precisa ter no minimo :min caracteres.',
        ], [
            'name' => 'Nome do responsavel',
            'subdomain' => 'Nome da plataforma',
            'email' => 'E-mail',
            'cellphone' => 'Celular',
            'cnpj' => 'CNPJ',
        ]);

        $user = User::query()->where('email', $this->email)->first();

        DB::beginTransaction();

        if (!$user) {
            $newUser = User::query()->create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make(Str::random(16)),
            ]);

            Tenant::query()->create([
                'main_user_id' => $newUser->id,
                'subdomain' => $this->subdomain,
                'cellphone' => $this->cellphone,
                'cnpj' => $this->cnpj,
            ]);

            $token = app(PasswordBroker::class)->createToken($newUser);
            Notification::route('mail', [
                $newUser->email => $newUser->name,
            ])->notify(new SendEmailNewUsers($newUser, $token));

            DB::commit();

            session()->flash('success', 'Cadastro realizado com sucesso. Você receberá um email em sua caixa de entrada');
            return $this->redirect(route('login'));
        }

        DB::rollBack();
        return $this->addError('email', 'Já existe uma conta com este e-mail.');
    }

    public
    function render()
    {
        return view('livewire.mechanical.auth.register');
    }
}
