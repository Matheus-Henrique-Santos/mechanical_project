<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Policies\BasePolicy;
use App\Requests\User\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController
{
    public function index($userFilters = null, $userOrder = null, $pageSize = null)
    {
        try {
            $userDB = User::query()
                ->join('model_has_roles', 'model_has_roles.model_id', 'users.id');

            if(isset($userOrder['column'])) {
                $userDB->orderBy($userOrder['column'], $userOrder['order']);
            }

            if(isset($userFilters['name'])){
                $userDB->where('name', 'like', "%{$userFilters['name']}%");
            }


            if (!is_null($pageSize)) {
                $userDB = $userDB->paginate($pageSize);
            } else {
                $userDB = $userDB->get();
            }

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Ops! aconteceu algum problema na listagem'
            ];
        }
    }

    public function show($id)
    {
        $userRequest = new UserRequest();
        $userRequest->validateId($id);

        try {
            $userDB = User::query()->with('roles','permissions')->findOrFail($id);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível encontrar este registro'
            ];
        }
    }

    public function update($id, $request)
    {
        $userRequest = new UserRequest;
        $userRequest->validateId($id);
        $requestValidated = $userRequest->validate($request, $id);

        try {
            $userDB = User::query()->findOrFail($id);

            $userDB->update($requestValidated);

            $this->associateRole($userDB,$requestValidated['role_id']);
            $userDB->refresh();

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB,
                'message' => 'Editado com sucesso!'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível atualizar'
            ];
        }
    }

    public function create($request)
    {
        $userRequest = new UserRequest;
        $requestValidated = $userRequest->validate($request);

        try {
            $userDB = User::query()->create($requestValidated);
            $this->associateRole($userDB,$requestValidated['role_id']);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB,
                'message' => 'Cadastrada com sucesso!'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível cadastrar'
            ];
        }
    }

    public function delete($id)
    {
        $userRequest = new UserRequest;
        $userRequest->validateId($id);
        DB::beginTransaction();
        try {
            $userDB = User::query()->findOrFail($id)->delete();

            DB::commit();
            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB,
                'message' => 'Excluído com sucesso!'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível excluir'
            ];
        }
    }

    public function getUsersNotInTeam($editable = false, $teamId = null)
    {
        try {
            $userDB = User::query()->when($editable, fn($query) => $query->whereDoesntHave('team', function ($query) use ($teamId) {
                $query->where('id', '!=', $teamId);
            }))->when(!$editable, fn($query) => $query->doesntHave('team'))->doesntHave('teams')->where('status', 'Ativo')->orderBy('name', 'ASC')->get();

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível encontrar registro'
            ];
        }
    }

    public function getUsersInCormmecialAndLicensed()
    {
        $authUser = auth()->user();
        $tenantDB = Tenant::query()
            ->with([
                'users' => function($query) {

                    if(auth()->user()->can('commercial_integrator_view_user')) {
                        $query->where('id', auth()->user()->id)->orderBy('name', 'ASC');
                    } else {
                        $query->where('status', 'Ativo')->orderBy('name', 'ASC');
                    }
                }
            ])
            ->where('status', 'Ativo')
            ->orderBy('name_display', 'ASC');

        if($authUser->tenant->scope == 'Comercial') {
            if ($authUser->can('commercial_commercial_order_view') && $authUser->can('commercial_licensed_order_view')) {
                $tenantDB = $tenantDB->whereIn('scope', ['Comercial','Licenciado'])->get();
            }elseif ($authUser->can('commercial_commercial_order_view')) {
                $tenantDB = $tenantDB->where('scope', 'Comercial')->get();
            } else if ($authUser->can('commercial_licensed_order_view')) {
                $tenantDB = $tenantDB->where('scope', 'Licenciado')->get();
            }

        } else if($authUser->tenant->scope == 'Licenciado') {
            $tenantDB = $tenantDB->where('id', auth()->user()->tenant_id)->get();
        } else if($authUser->tenant->scope == 'Time') {
            $tenantDB = $tenantDB->whereIn('scope', ['Comercial','Licenciado'])->get();
        }

        return $tenantDB;
    }

    public function associateRole($userDB, $role_id)
    {
        $userRequest = new UserRequest;
        $userRequest->validateRoleId($role_id);

        try {
            $userDB->roles()->sync($role_id);

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB,
                'message' => 'Nível de acesso, associado com sucesso!'
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Deu algum problema para associar um nível de acesso'
            ];
        }
    }

    public function addTokenRecoveryByUser($id, $token)
    {
        try {
            $userDB = User::query()->withoutGlobalScope('tenant')->findOrFail($id);

            $userDB->update(['token' => $token]);
            $userDB->refresh();

            return [
                'status' => 'success',
                'code' => 200,
                'data' => $userDB,
                'message' => 'Editado com sucesso!'
            ];

        } catch (\Exception $exception) {
            return [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => 'Não foi possível atualizar'
            ];
        }
    }
}
