<?php

namespace App\Livewire\Mechanical\User;

use App\Http\Controllers\UserController;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\Livewire\WithModal;
use App\Traits\Livewire\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use stdClass;
use function view;

class Form extends Component
{
    use WithPagination, WithModal, WithToast;

    public $state = [
        'role_id' => '',
        'status' => ''
    ];

    public $user;
    public $user_id;

    public function mount($id = null)
    {
//        if ($id) {
//            $this->user_id = $id;
//            $this->getUser();
//        }
    }

    public function getUser()
    {
//        $this->state['tenant_id'] = auth()->user()->tenant_id;

        if ($this->user_id) {
            $userRepository = new UserController;
            $this->user = $userRepository->show($this->user_id);

            $this->state = $this->user['data']->toArray();
            $this->state['role_id'] = $this->user['data']->roles->first()->id ?? null;
        }
    }

    public function getRoles()
    {
        $roleRepository = new UserController();
        return $roleRepository->index()['data'];
    }

    public function update()
    {
        $request = $this->state;
        $roleRepository = new UserController;
        $userUpdateReturn = $roleRepository->update($this->user['data']['id'], $request);

        if ($userUpdateReturn['status'] != 'success') {
            $this->openToast('Usuário',$userUpdateReturn['message'], 'danger');
        } else if ($userUpdateReturn['status'] != 'error') {
            $this->openToast('Usuário',$userUpdateReturn['message']);
            $this->emit('refreshTableUser');

        }
        $this->closeModal();
    }

    public function save()
    {
        if ($this->user) {
            return $this->update();
        }

        $request = $this->state;

        $roleRepository = new UserController;
        $userCreateReturn = $roleRepository->create($request);

        if ($userCreateReturn['status'] != 'success') {
            $this->openToast('Usuário',$userCreateReturn['message'], 'danger');
        } else if ($userCreateReturn['status'] != 'error') {
            $this->openToast('Usuário',$userCreateReturn['message']);
            $this->emit('refreshTableUser');
        }

        $this->closeModal();
    }

    public function render()
    {
        $response = new StdClass;
        $response->user = $this->user;
        $response->roles = $this->getRoles();

        return view('livewire.mechanical.user.form', ['response' => $response]);
    }
}
