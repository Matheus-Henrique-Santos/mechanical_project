<?php

namespace App\Livewire\Mechanical\User;

use App\Http\Controllers\UserController;
use App\Traits\Livewire\WithModal;
use App\Traits\Livewire\WithPageSize;
use App\Traits\Livewire\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use stdClass;

class Table extends Component
{
    use WithPagination, WithModal, WithToast, WithPageSize;

    protected $listeners = [
        'refreshTableUser' => '$refresh',
        'confirmDeleteUser' => 'delete',
        'order-table-user' => 'orderTableUser',
        'filterUser'
    ];

    public $order = [
        'column' => 'name',
        'order' => 'ASC'
    ];

    public $filters;

    public function getUsers()
    {
        $userRepository = new UserController();
        return $userRepository->index($this->filters, $this->order, $this->pageSize)['data'];
    }


    public function orderTableUser($column)
    {
        dd('aqui');
        if (is_null($this->order['order'])) {
            $this->order['order'] = 'ASC';
        }
        else if ($this->order['order'] === 'ASC') {
            $this->order['order'] = 'DESC';
        }
        else if ($this->order['order'] === 'DESC') {
            $this->order['order'] = 'ASC';
        }
        $this->order['column'] = $column;
    }

    public function filterUser($filter)
    {
        $this->filters = $filter;

        $this->resetPage();

    }

    public function delete($id)
    {
        $userRepository = new UserController;

        $userDeleteReturn = $userRepository->delete($id);

        if ($userDeleteReturn['status'] != 'success') {
            $this->openToast('Usuário',$userDeleteReturn['message'],'danger');
        } else if ($userDeleteReturn['status'] != 'error') {
            $this->openToast('Usuário',$userDeleteReturn['message']);
        }

        $this->closeConfirmModal();
    }

    public function render()
    {
        $response = new StdClass;
        $response->users = $this->getUsers();

        return view('livewire.mechanical.user.table', ['response' => $response]);
    }
}
