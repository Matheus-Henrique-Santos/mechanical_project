<?php

namespace App\Livewire\Mechanical\User\Permission;

use App\Http\Controllers\UserController;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\Livewire\WithModal;
use App\Traits\Livewire\WithToast;
use Livewire\Component;
use stdClass;
use function view;

class Form extends Component
{
    use WithModal, WithToast, WithToast;

    public $state = [];

    public $user_id;

    public $permissions = [];

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getPermissions()
    {
        $userRepository = new UserController;

        $user = $userRepository->show($this->user_id);
        $this->state = $user['data'];

        $this->permissions = collect($user['data']['permissions'])->keyBy('id')->map(function(){
            return true;
        })->toArray();
    }

    public function getGroupPermissions()
    {
        $roleRepository = new UserController();
        return $roleRepository->getGroupPermissions()['data'];
    }

    public function save()
    {
        $request = $this->state;

        $userRepository = new UserController();
        $user = $userRepository->show($request['id']);

        $permissionsIds = array_keys(array_filter($this->permissions, function ($item) {
            return $item;
        }));

        $userPermissionsReturn = $userRepository->updateAssociatePermissions($user['data']['id'], $permissionsIds);

        if ($userPermissionsReturn['status'] != 'success') {
            $this->openToast('Permissões',$userPermissionsReturn['message'], 'danger');
        } else if ($userPermissionsReturn['status'] != 'error') {
            $this->openToast('Permissões',$userPermissionsReturn['message']);
            $this->emit('refreshTableUser');
        }

        $this->closeModal();
    }

    public function render()
    {
        $this->getPermissions();

        $response = new StdClass;
        $response->groups = $this->getGroupPermissions();

        return view('livewire.mechanical.user.form', ['response' => $response]);
    }
}
