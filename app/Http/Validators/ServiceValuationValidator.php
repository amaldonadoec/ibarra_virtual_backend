<?php

namespace App\Http\Validators;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceValuationValidator
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
                'comment' => 'required|max:128',
                'star' => 'required|numeric|max:5|min:1',
                "service_id" => 'required|exists:services,id',
            ]
        );

        if ($validator->fails()) {
            throw new CustomValidationException($validator);
        }
        return true;
    }

}