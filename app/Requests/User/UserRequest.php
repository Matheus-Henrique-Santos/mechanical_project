<?php

namespace App\Requests\User;

use App\Contracts\BaseRequestContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRequest implements BaseRequestContract
{

    public function validate($request, $id = null)
    {
        $request = $this->prepareForValidation($request);

        return Validator::validate($request,[
            'name' => 'required',
            'phone' => 'required|min:10',
            'role_id' => 'required',
            'reev_token' => 'sometimes',
            'email'=> [
                'required',
                'email',
                Rule::unique('users')->where('tenant_id', auth()->user()->tenant_id)->ignore($id)
            ],
            'password'=> [
                'required_with:confirm_password',
                Rule::requiredIf(function() use($request){
                    return !isset($request['id']);
                })],
            'confirm_password' => 'required_with:password|same:password',
            'status' => 'required'
        ]);
    }

    public function validateRoleId($role_id)
    {
        return abort_if(!is_null($role_id) && !is_numeric($role_id), 404);
    }

    public function validateId($id)
    {
        return abort_if(!is_null($id) && !is_numeric($id), 404);
    }

    protected function prepareForValidation($request)
    {
        if (isset($request['phone'])) {
            $request['phone'] = str_replace(['(',')', ' ','-', '_'], '', $request['phone']);
        }

        return $request;
    }
}
