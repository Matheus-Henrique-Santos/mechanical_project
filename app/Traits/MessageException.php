<?php

namespace App\Traits;

use App\Models\Error;

trait MessageException
{

    public function getMessage(\Exception $exception)
    {
        $code = Error::create([
            'user_id' => auth()->id(),
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ]);

        return "Ops! Não foi possível realizar essa ação.
Caso esse erro volte a acontecer, por favor informe o código abaixo para sua atendente.
{$code->id}";
    }
}
