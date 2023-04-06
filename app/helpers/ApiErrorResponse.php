<?php

namespace App\Helpers;


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ApiErrorResponse
{

public function failedValidation(Validator $validator ){
        throw new HttpResponseException(response()->json([

            'success'=>false,
            'message'=> 'validation error',
            'errors' => $validator->errors()

        ]));
    }

}