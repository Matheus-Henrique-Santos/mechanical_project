<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AddressService
{
    static function getAddress($zipCode)
    {
        if(strlen($zipCode) != 9) {
            return false;
        } else {
            $address = self::getAddressByBrasilApi($zipCode);

            if(!$address) {
                $address = self::getAddressByViaCep($zipCode);
            }

            if (!$address) {
                Log::channel('daily')->notice('CEP ' . $zipCode . ' não encontrado.');
                return false;
            }

            return $address;
        }
    }

    static function getAddressByBrasilApi($zipCode)
    {
        $addressApi = Http::get('https://brasilapi.com.br/api/cep/v1/'.$zipCode)->object();
        if(isset($addressApi->state)){
            $address['st'] = $addressApi->state;
            $address['city'] = $addressApi->city;
            $address['neighborhood'] = $addressApi->neighborhood;
            $address['address'] = $addressApi->street;
            return $address;
        } else {
            return false;
        }
    }

    static function getAddressByViaCep($zipCode)
    {
        $addressApi = Http::get('https://viacep.com.br/ws/' . str_replace('-','', $zipCode) . '/json/')->object();
        if(isset($addressApi->uf)){
            $address['st'] = $addressApi->uf;
            $address['city'] = $addressApi->localidade;
            $address['neighborhood'] = $addressApi->bairro;
            $address['address'] = $addressApi->logradouro;
            return $address;
        } else {
            return false;
        }
    }
}
