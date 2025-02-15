<?php

namespace App\Livewire\Mechanical\Auth;

use App\Models\User;
use App\Services\AddressService;
use Livewire\Component;

class Register extends Component
{
    public $formData = [];
    public $zipCode;
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
        $validatedData = $this->validate([
            'formData.socialName' => 'required',
            'formData.fantasyName' => 'required',
            'formData.cnpj' => 'required',
            'formData.cellphone' => 'required',
            'zipCode' => 'required',
            'formData.city' => 'required',
            'formData.uf' => 'required',
            'formData.address' => 'required',
            'formData.neighborhood' => 'required',
            'formData.number' => 'required',
            'formData.complement' => 'required',
            'formData.name' => 'required',
            'formData.cpf' => 'required',
            'formData.email' => 'required',
            'formData.password' => 'required',
            'formData.password_confirmed' => 'required',
        ], [
            'required' => ':attribute é obrigatório.',
        ], [
            'formData.name' => 'Nome',
            'formData.cpf' => 'CPF',
            'formData.cnpj' => 'CNPJ',
            'formData.cellphone' => 'Celular',
            'formData.email' => 'E-mail',
            'formData.password' => 'Senha',
            'formData.socialName' => 'Razão Social',
            'formData.fantasyName' => 'Nome Fantasia',
            'zipCode' => 'CEP',
            'formData.city' => 'Cidade',
            'formData.uf' => 'UF',
            'formData.address' => 'Endereço',
            'formData.neighborhood' => 'Bairro',
            'formData.number' => 'Número',
            'formData.complement' => 'Complemento',
            'formData.password_confirmed' => 'Confirmação de senha',
        ]);
    }

    public function render()
    {
        return view('livewire.mechanical.auth.register');
    }
}
