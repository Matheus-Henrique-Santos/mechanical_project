<?php

namespace App\Livewire\Mechanical\Tenants;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $name;
    public $email;
    public $address;
    public $type = 'pf'; // Default: Pessoa Física
    public $document;
    public $phone;
    public $subdomain;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'address' => 'nullable|string|max:255',
        'document' => 'required|unique:tenants,cnpj',
        'phone' => 'nullable|string|max:15',
        'subdomain' => 'required|unique:tenants,subdomain',
    ];

    protected $messages = [
        'name.required' => 'O nome da empresa é obrigatório.',
        'email.required' => 'O email é obrigatório.',
        'email.unique' => 'Este email já está cadastrado.',
        'document.unique' => 'Este documento já está cadastrado.',
        'type.required' => 'Selecione o tipo de pessoa.',
        'subdomain.required' => 'O subdominio precisa ser preenchido.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        DB::transaction(function () {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt('teste2'),
            ]);

            // Criar o tenant
            $tenant = Tenant::create([
                'name' => $this->name,
                'main_user_id' => $user->id,
                'address' => $this->address,
                'cnpj' => $this->document,
                'phone' => $this->phone,
                'subdomain' => $this->subdomain,
            ]);


            $user->update([
                'tenant_id' => $tenant->id,
            ]);

            session()->flash('success', 'Tenant cadastrado com sucesso!');
            $this->reset(); // Limpa os campos
        });
    }


    public function render()
    {
        return view('livewire.mechanical.tenant-register');
    }
}
