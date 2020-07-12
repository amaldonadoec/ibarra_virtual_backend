<?php

namespace App\Http\Validators;

use App\Exceptions\CustomValidationException;
use Illuminate\Support\Facades\Validator;

class CompanyValidator
{

    /**
     * @param $idCompany
     * @return bool
     * @throws CustomValidationException
     */
    public function validateShow($idCompany)
    {
        $validator = Validator::make(
            ['company_id' => $idCompany],
            [
                "company_id" => 'required|exists:companies,id',
            ]
        );

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }
        return true;
    }

}