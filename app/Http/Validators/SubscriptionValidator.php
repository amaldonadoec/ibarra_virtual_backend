<?php

namespace App\Http\Validators;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionValidator
{

    /**
     * @param Request $request
     * @return bool
     * @throws CustomValidationException
     */
    public function validate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'uid' => [
                    'required',
                    'max:45'
                ],
                'display_name' => 'required|max:128',
                'email' => 'required|max:45',
                "company_id" => 'required|exists:companies,id',
            ]
        );

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }
        return true;
    }

}