<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RolesManagement extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $roleId;
    public $name;
    public $label;
    public $selectedPermissions = [];
    public $allPermissions;

    protected $rules = [
        'name' => 'required|min:3|unique:roles,name',
        'label' => 'required',
        'selectedPermissions' => 'required|array|min:1'
    ];

    public function mount()
    {
        $this->allPermissions = Permission::all();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'label' => $this->label
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Papel criado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $id;
        $this->name = $role->name;
        $this->label = $role->label;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();

        $this->openModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|unique:roles,name,'.$this->roleId,
            'label' => 'required',
            'selectedPermissions' => 'required|array|min:1'
        ]);

        $role = Role::find($this->roleId);
        $role->update([
            'name' => $this->name,
            'label' => $this->label
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Papel atualizado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        session()->flash('message', 'Papel excluído com sucesso.');
    }

    private function resetInputFields()
    {
        $this->roleId = null;
        $this->name = '';
        $this->label = '';
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.roles-management', [
            'roles' => Role::with('permissions')->paginate(10)
        ]);
    }
}
