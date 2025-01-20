<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $roles, $name, $label, $role_id;
    public $isOpen = false;

    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.roles');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role_id,
            'label' => 'nullable',
        ]);

        Role::updateOrCreate(['id' => $this->role_id], [
            'name' => $this->name,
            'label' => $this->label,
        ]);

        session()->flash('message', $this->role_id ? 'Role atualizada com sucesso.' : 'Role criada com sucesso.');

        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->label = $role->label;

        $this->openModal();
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        session()->flash('message', 'Role excluída com sucesso.');
    }

    private function resetFields()
    {
        $this->role_id = null;
        $this->name = '';
        $this->label = '';
    }
}
