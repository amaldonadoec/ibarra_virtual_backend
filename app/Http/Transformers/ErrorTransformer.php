<?php

namespace App\Http\Transformers;

class ErrorTransformer
{

    /**
     * Transforms the errors array that comes from validation
     * @param $errors
     * @return array
     */
    public static function transformValidationErrors($errors)
    {
        // used to store all the warnings generated by the validator
        $formatedErrors = array();

        foreach ($errors->keys() as $key) {
            $error = [
                'code' => null,
                'field' => $key,
                'value' => $errors->first($key)
            ];
            array_push($formatedErrors, $error);
        }

        // return errors
        return $formatedErrors;
    }

}