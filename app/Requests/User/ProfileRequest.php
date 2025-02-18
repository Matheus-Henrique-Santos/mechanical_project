<?php

namespace App\Requests\User;

use App\Contracts\BaseRequestContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileRequest implements BaseRequestContract
{
    public function validate($request, $id = null, $tenant_id = null)
    {
        $request = $this->prepareForValidation($request);

        return Validator::validate($request,[
            'tenant_id' => 'required',
            'name'=>'required',
            'phone' =>  'required|min:10',
            'email'=> [
                'required',
                'email',
                Rule::unique('users')->when($tenant_id, fn($query) => $query->where('tenant_id',$tenant_id))->ignore($id)
            ],

        ], [
            'phone.min' => 'O campo telefone é obrigatório'
        ]);
    }

    protected function prepareForValidation($request)
    {
        if (isset($request['phone'])) {
            $request['phone'] = str_replace(['(',')', ' ','-', '_'], '', $request['phone']);
        }

        return $request;
    }

    public function validatePassword($request, $id = null)
    {
        return Validator::validate($request,[

            'current_password' => [
                'required_with:password', function ($attribute, $request, $fail) {
                if (!\Hash::check($request, auth()->user()->password)) {
                    return $fail(__('Senha Atual Incorreta'));
                }
            }],

            'password'=> [
                'required',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'required_with:current_password',
                'different:current_password',
                Rule::requiredIf(function() use($request){
                return !isset($request['id']);
            })],

            'password_confirmation' => 'required_with:password|same:password',
        ]);
    }

    public function validateImage($request, $id = null)
    {
        return Validator::validate($request,[
            'midia' => 'sometimes',
            'file' => [
                Rule::excludeIf(fn () => (isset($request['file']) && is_null($request['file'])) || (isset($request['file']) && is_string($request['file']))),
                'nullable',
                'image'
            ]
        ]);
    }

    public function validateId($id)
    {
        return abort_if(!is_null($id) && !is_numeric($id), 404);
    }
}
