<?php

namespace App\Livewire\Mechanical;

use App\Models\Tenant;
use Livewire\Component;

class TenantRegister extends Component
{
    public $name;
    public $email;
    public $address;
    public $type = 'pf'; // Default: Pessoa Física
    public $document;
    public $phone;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:tenancies,email',
        'address' => 'nullable|string|max:255',
        'type' => 'required|in:pf,pj',
        'document' => 'required|unique:tenancies,document',
        'phone' => 'nullable|string|max:15',
    ];

    protected $messages = [
        'name.required' => 'O nome da empresa é obrigatório.',
        'email.required' => 'O email é obrigatório.',
        'email.unique' => 'Este email já está cadastrado.',
        'document.required' => 'O CPF ou CNPJ é obrigatório.',
        'document.unique' => 'Este documento já está cadastrado.',
        'type.required' => 'Selecione o tipo de pessoa.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        // Criar o tenant
        Tenant::create([
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'type' => $this->type,
            'document' => $this->document,
            'phone' => $this->phone,
        ]);

        session()->flash('success', 'Tenant cadastrado com sucesso!');
        $this->reset(); // Limpa os campos
    }


    public function render()
    {
        return view('livewire.mechanical.tenant-register');
    }
}
