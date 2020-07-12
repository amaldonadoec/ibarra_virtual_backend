<?php

namespace App\Http\Validators;

use App\Exceptions\CustomValidationException;
use Illuminate\Support\Facades\Validator;

class ServiceValidator
{

    /**
     * @param $idService
     * @return bool
     * @throws CustomValidationException
     */
    public function validateShow($idService)
    {
        $validator = Validator::make(
            ['service_id' => $idService],
            [
                "service_id" => 'required|exists:services,id',
            ]
        );

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }
        return true;
    }

}